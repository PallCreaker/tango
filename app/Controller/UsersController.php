<?php

class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('User', 'Profile');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }

    //JSON型のデータをデコードして登録＝＞そのユーザーの情報をJSONで返す
    public function register() {
        $error = json_encode(array());
        $user = json_encode(array());
        
        if ($this->request->is('post')) {
            $this->request->data['User']['password'] = hash('md5', $this->request->data['User']['password']);
            if($this->User->user_already($this->request->data['User']['username']) == false){
                if ($this->User->save($this->request->data)) {
                //登録したユーザーの情報を配列で返す
                $user = json_encode($this->User->get_specify_user($this->User->getLastInsertID()));
                //ユーザーIDをprofilesにしまう
                $profile = array(
                    'user_id' => $this->User->getLastInsertId()
                );

                if ($this->Profile->save($profile)) {
                    $error = $this->error200('ユーザー登録が完了しました');
                } else {
                    $error = $this->error400('ユーザー登録に失敗しました');
                }
            } else {
                $error = $this->error400('ユーザー登録に失敗しました');
            }
            } else {
                $error = $this->error403('そのユーザー名は既に使用されています');
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }
        
        $this->set(compact('error', 'user'));
    }

    //特定のユーザー情報を返す
    public function get_user($user_id = null) {
        $this->User->id = $user_id;
        if ($this->User->exists()) {
            $user = json_encode($this->User->get_specify_user($user_id));
        } else {
            $error = $this->error404('指定したidのユーザーは存在しません');
        }
        $this->set(compact('user', 'error'));
    }

    //ユーザー削除（今は、statusを0にして、削除したことにする仕様＝＞データを残す）
    public function delete($user_id = null) {
        $this->User->id = $user_id;
        $data = array('status' => 0);
        $this->User->save($data);
    }
}