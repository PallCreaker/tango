<?php

class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('User');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function register() {
        if ($this->request->is('post')) {
            $this->request->data['User']['password'] = hash('md5', $this->request->data['User']['password']);
            if ($this->User->save($this->request->data)) {
                $user = json_encode($this->User->get_specify_user($this->User->getLastInsertID()));
                $this->set('user', $user);
            }
        }
    }
    
    public function get_user($user_id = null) {
        $this->User->id = $user_id;
        if($this->User->exists()) {
            $user = json_encode($this->User->get_specify_user($user_id));
            $this->set('user', $user);
        } else {
            $error = json_encode($this->error404('指定したidのユーザーは存在しません'));
            $this->set('error', $error);
        }
    }
    
    // =====================================================================
    public function index() {
        $title = 'Home';
        $user = $this->User->get_user_data($this->Auth->User('id'));
        $this->set(compact('title', 'user'));
    }

    public function view($user_id = null) {
        if ($user_id != $this->Auth->User('id')) {
            $user = $this->User->get_user_data($user_id);
            $title = $user['User']['username'];
            $friends = $this->Friend->get_friend_list($this->Auth->User('id'));
            $friend_flag = 0;
            foreach($user['FriendsRequest'] as $friends_request) {
                if($friends_request['from_id'] == $this->Auth->User('id')) {
                    $friend_flag = 1;
                    break;
                }
            }
            foreach($friends as $friend) {
                if($friend['Friend']['user1_id'] == $this->Auth->User('id') || $friend['Friend']['user2_id'] == $this->Auth->User('id')) {
                    $friend_flag = 2;
                    break;
                }
            }
            $this->set(compact('title', 'user', 'friend_flag', 'friends'));
        } else {
            $this->not_found();
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash('Login success', 'default', array(), 'success');
                $this->redirect('/users');
            } else {
                $this->Session->setFlash('Login failed', 'default', array(), 'failed');
            }
        } else {
            if ($this->Auth->User()) {
                $this->redirect('/users');
            } else {
                $title = 'Login';
                $this->set(compact('title'));
            }
        }
    }

    public function logout() {
        if ($this->Auth->logout()) {
            $this->Session->setFlash('Logout', 'default', array(), 'success');
            $this->redirect('/users/login');
        }
    }

    

}