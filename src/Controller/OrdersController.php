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
        $this->Auth->allow(['enter', 'error', 'complete']);
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

    public function enter($userId = null, $hashId = null)
    {
        if ($userId > 0) {
            $user = $this->Orders->Users->get($userId);
            if ((!isset($user->order_token) || $user->order_token != $hashId)) {
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
                        $allSuccess = false;
                        $this->Flash->error(__('Unable to add the order for cookie type - ' . $orderData['cookie_id']));
                    }
                }
            }

            if ($allSuccess) {
                // Prevent coming back later
                $user->order_token = null;
                $this->Orders->Users->save($user);

                $totalCookies = $request['totalCookies'];
                $totalMoney = $request['totalMoney'];

                $email = new Email('default');
                $result = $email->template('receipt', 'default')
                    ->emailFormat('html')
                    ->viewVars(['orders' => $orders, 'totalMoney' => $totalMoney, 'totalCookies' => $totalCookies])
                    ->to($user->email)
                    ->subject('Cookie Order Receipt')
                    ->send();

                return $this->redirect(['action' => 'complete']);
            }
        }

        $cookies = $this->Orders->Cookies->find('all')->where('Cookies.not_for_delivery = 0')->order('Cookies.name');
        $this->set(compact('cookies', 'user'));
    }

    public function add($userId = null) {

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $allSuccess = true;
            $userId = $request['user_id'];
            $cookieBoothUser = $this->Orders->Users->find('all')->where(['access_level' => 20])->first();
            $orders = [];
            foreach ($request['order'] as $orderData) {
                if ($orderData['quantity'] > 0) {
                    // Add
                    $orderData['user_id'] = $userId;
                    $order = $this->Orders->newEntity();
                    $order = $this->Orders->patchEntity($order, $orderData);
                    $orders[] = $orderData;
                    if (!$this->Orders->save($order)) {
                        $this->Flash->error(__('Unable to add the order for cookie type - ' . $orderData['cookie_id']));
                        return;
                    }

                    // Subtract from Cookie Booth
                    $orderData['user_id'] = $cookieBoothUser->id;
                    $orderData['quantity'] = $orderData['quantity'] * -1;
                    $order = $this->Orders->newEntity();
                    $order = $this->Orders->patchEntity($order, $orderData);
                    if (!$this->Orders->save($order)) {
                        $this->Flash->error(__('Unable to debit order from Cookie Booth for cookie type - ' . $orderData['cookie_id']));
                        return;
                    }
                }
            }
            $this->Flash->success(__('The order has been updated.'));
            return $this->redirect(['action' => 'index']);
        } 

        $user = $this->Orders->Users->get($userId);
        $cookies = $this->Orders->Cookies->find('all')->where(['Cookies.not_for_delivery' => false])->order('Cookies.name');
        $this->set(compact('cookies', 'user'));
    }

    public function inventory($userId) {
        $user = $this->Orders->Users->get($userId);
        $ordersQuery = $this->Orders->find('all')
            ->contain(['Cookies'])
            ->order('Cookies.name')
            ->where(['Orders.user_id' => $userId, 'Cookies.not_for_delivery ' => 0]);

        $cookies = $this->Orders->Cookies->find('all')->order('Cookies.name');

        // Combine
        $ordersQuery = $ordersQuery->select([
                'cookie_id',
                'count' => $ordersQuery->func()->sum('quantity')
            ])->group('cookie_id');
        $orders  = Hash::combine($ordersQuery->toArray(), '{n}.cookie_id', '{n}.count');

        $this->set(compact('orders', 'cookies', 'user'));
    }

    public function pickup($userId) {
        $user = $this->Orders->Users->get($userId);
        $ordersQuery = $this->Orders->find('all')
            ->contain(['Cookies'])
            ->order('Cookies.name')
            ->where(['Orders.user_id' => $userId, 'Cookies.not_for_delivery ' => 0]);

        if ($this->request->is(['patch', 'post', 'put'])) {    
            $request = $this->request->getData();    
            $user->pickup_confirmed = true;
            $this->Orders->Users->save($user);

            $totalMoney = $request['totalMoney'];
            $totalCookies = $request['totalCookies'];
            $orders = $this->Orders->find('all')->where(['Orders.user_id' => $userId])->contain(['Cookies']);

            $email = new Email('default');
            $result = $email->template('pickup', 'default')
                ->emailFormat('html')
                ->viewVars(['orders' => $ordersQuery, 'totalMoney' => $totalMoney, 'totalCookies' => $totalCookies])
                ->to($user->email)
                ->subject('Cookie Pickup Receipt')
                ->send();
            $this->Flash->success(__('The pickup has been confirmed.'));
            return $this->redirect(['action' => 'index']);
        }

        $cookies = $this->Orders->Cookies->find('all')->order('Cookies.name');

        // Combine
        $ordersQuery = $ordersQuery->select([
                'cookie_id',
                'count' => $ordersQuery->func()->sum('quantity')
            ])->group('cookie_id');
        $orders  = Hash::combine($ordersQuery->toArray(), '{n}.cookie_id', '{n}.count');

        $this->set(compact('orders', 'cookies', 'user', 'isCookieBooth'));
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