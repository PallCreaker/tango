<?php

class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('User');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }

    //JSON型のデータをデコードして登録＝＞そのユーザーの情報をJSONで返す
    public function register() {
        if ($this->request->is('post')) {
            $this->request->data['User']['password'] = hash('md5', $this->request->data['User']['password']);
            if ($this->User->save(json_decode($this->request->data))) {
                //登録したユーザーの情報をJSON形式で返す
                $user = json_encode($this->User->get_specify_user($this->User->getLastInsertID()));
                $this->set('user', $user);
            }
        }
    }
    //特定のユーザー情報を返す
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
    //ユーザー削除
    public function delete ($user_id = null) {
        $data = array('User', array('id' => $user_id, 'status' => 0));
        $this->User->save($data);
    }
}