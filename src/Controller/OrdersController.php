<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class OrdersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'error', 'complete']);
    }

    public function index()
    {
        $usersData = $this->Orders->Users->find('all', ['keyField' => 'username'])
            ->order('Users.username')
            ->where('Users.access_level <= 60');
        $orderData = $this->Orders->find('all')
            ->contain(['Users','Cookies']);

        $users  = Hash::combine($usersData->toArray(), '{n}.id', '{n}');

        foreach ($users as $id => $user) {
            $users[$id]['orders'] = [];
            foreach ($orderData as $order) {
                if ($user->id == $order->user->id) {
                    $users[$id]['orders'][] = $order;
                }
            }
        }
        $this->set('users',$users);
    }

    public function request($userId) {
        $user = $this->Orders->Users->get($userId);
        if ($user != null) {
            if (isset($user->email)) {
                $hashedKey = Security::hash(Text::uuid(),'sha256',true);
                $user->order_token = $hashedKey;
                $this->Orders->deleteAll(['user_id' => $userId]);

                if ($this->Orders->Users->save($user))
                {
                    $email = new Email('default');
                    $result = $email->template('order', 'default')
                        ->emailFormat('html')
                        ->viewVars(['orderLink' => Router::url( ['controller'=>'orders','action'=>'add', '_ssl' => true], true )."/{$userId}/{$hashedKey}"])
                        ->to($user->email)
                        ->subject('Submit Your Cookie Order')
                        ->send();
                    if ($result) {
                        $this->Flash->success(__('User sent request for order.'));
                    }
                } else {
                    $this->Flash->error(__('Could not send a order email.'));
                }
            } else {
                $this->Flash->error(__('Could not find email address, try again.'));
            }
        }
                  
        // Will throw exception if not found
        return $this->redirect(['action' => 'index']);
    }

    public function booth($userId) {
        $user = $this->Orders->Users->get($userId);
        $cookies = $this->Orders->Cookies->find('all')->order('Cookies.name');
        $ordersQuery = $this->Orders->find();
        $ordersQuery->select([
                'cookie_id',
                'count' => $ordersQuery->func()->sum('quantity')
            ])->group('cookie_id');
        $orders  = Hash::combine($ordersQuery->toArray(), '{n}.cookie_id', '{n}.count');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $allSuccess = true;
            $userId = $request['user_id'];
            $orders = [];
            foreach ($request['order'] as $orderData) {
                if ($orderData["quantity"] > 0) {
                    $orderData['user_id'] = $userId;
                    // Add
                    $order = $this->Orders->newEntity();
                    $order = $this->Orders->patchEntity($order, $orderData);
                    $orders[] = $orderData;
                    if (!$this->Orders->save($order)) {
                        $this->Flash->error(__('Unable to add the order for cookie type - ' . $orderData['cookie_id']));
                    }
                }
            }

            if ($allSuccess) {
                $this->Flash->success(__('The order has been saved.'));       
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('cookies', 'orders', 'user'));
    }

    public function add($userId = null, $hashId = null)
    {
        $externalView = true;
        $authLevel = $this->Auth->user('access_level');
        $isTCM = false;
        if ($authLevel >= Configure::read('AuthRoles.leader')) {
            $isTCM = true;
            $externalView = false;
        }

        if ($userId > 0) {
            $user = $this->Orders->Users->get($userId);
            if (!$isTCM && (!isset($user->order_token) || $user->order_token != $hashId)) {
                return $this->redirect(['action' => 'error']);
            }
        } else {
            $user = null;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $allSuccess = true;
            $userId = $request['user_id'];
            $orders = [];
            foreach ($request['order'] as $orderData) {
                if ($orderData["quantity"] > 0) {
                    $orderData['user_id'] = $userId;
                    // Add
                    $order = $this->Orders->newEntity();
                    $order = $this->Orders->patchEntity($order, $orderData);
                    $orders[] = $orderData;
                    if (!$this->Orders->save($order)) {
                        $this->Flash->error(__('Unable to add the order for cookie type - ' . $orderData['cookie_id']));
                    }
                }
            }

            if ($allSuccess) {
                if (isset($user)) {
                    // Prevent coming back later
                    $user->order_token = null;
                    $this->Orders->Users->save($user);
   
                    $totalCookies = $request['totalCookies'];
                    $totalMoney = $request['totalMoney'];

                    $email = new Email('default');
                    $result = $email->from(['toddrogers3286@gmail.com' => 'The Cookie Mom'])
                        ->template('receipt', 'default')
                        ->emailFormat('html')
                        ->viewVars(['orders' => $orders, 'totalMoney' => $totalMoney, 'totalCookies' => $totalCookies])
                        ->to($user->email)
                        ->subject('Cookie Order Receipt')
                        ->replyTo('toddrogers3286@gmail.com')
                        ->send();

                    if ($isTCM) {
                        $this->Flash->success(__('The order has been saved.'));       
                        return $this->redirect(['action' => 'index']);
                    } else {
                        return $this->redirect(['action' => 'complete']);
                    }
                }
            }
        }

        $cookies = $this->Orders->Cookies->find('all')->order('Cookies.name');
        $this->set(compact('cookies', 'user', 'externalView'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function error() {}

    public function complete() {}
}