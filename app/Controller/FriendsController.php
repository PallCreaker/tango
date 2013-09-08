<?php

class FriendsController extends AppController {
    public $name = 'Friends';
    public $uses = array('Friend', 'User');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function add() {
        if($this->request->is('post')){
            $this->Profile->save(json_decode($this->request->data));
        }
    }
    
    public function get_friends($user_id = null) {
        $this->Friend->user_id1 = $user_id;
        if($this->request->is('post')) {
            $friends_list = json_encode($this->Friend->get_friends_list($user_id));
            $this->set('friends_list', $friends_list);
        } else {
            $error = json_encode($this->error404('指定された友達がいません'));
            $this->set('error', $error);
        }
    }
}
