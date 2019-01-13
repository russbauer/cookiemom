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

class CookiesController extends AppController
{
    public function index()
    {
        $cookies = $this->Cookies->find('all')->order('Cookies.name');
        $this->set('_serialize', 'cookies');
        $this->set('cookies', $cookies);
    }

    public function edit($cookieId = null)
    {
        // Edit
        if ($cookieId) {
            $cookie = $this->Cookies->get($cookieId);
        } else {  
            // Add - first load
            $cookie = $this->Cookies->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $cookie = $this->Cookies->patchEntity($cookie, $request);
            
            if ($this->Cookies->save($cookie)) {
                $this->Flash->success(__('The cookie has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the cookie.'));
        }
        $this->set(compact('cookie', 'cookieId'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cookie = $this->Cookies->get($id);
        if ($this->Cookies->delete($cookie)) {
            $this->Flash->success(__('The cookie has been deleted.'));
        } else {
            $this->Flash->error(__('The cookie could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}