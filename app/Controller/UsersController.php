<?php

class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('User', 'Profile');
    public $layout = 'json';

    //JSON型のデータをデコードして登録＝＞そのユーザーの情報をJSONで返す
    public function register() {
        $error = json_encode(array());
        $user = json_encode(array());
        
        if ($this->request->is('post')) {
            $this->request->data['User']['password'] = $this->User->hash_password($this->request->data['User']['password']);
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
    public function get_user($user_id = NULL){
        $error = json_encode(array());
        $user = json_encode(array());
        
        if($this->request->is('get')){
            $this->User->id = $user_id;
            if($this->User->exists()){
                $error = $this->error200('指定されたユーザーデータです');
                $user = json_encode($this->User->find('first', array(
                    'conditions' => array('id' => $user_id),
                    'recursive' => -1
                )));
            } else {
                $error = $this->error404('指定されたユーザーは存在しません');
            }
        } else {
            $error = $this->error403('リクエスト形式が適切ではありません');
        }
        
        $this->set(compact('error', 'user'));
    }
    //ユーザー削除（今は、statusを0にして、削除したことにする仕様＝＞データを残す）
    public function delete($user_id = null) {
       $error = json_encode(array());
       $users = json_encode(array());
        
        if($this->request->is('get')){
            $this->User->id = $user_id;
            if($this->User->exists()){
                if($this->User->delete($user_id)){
                    $error = $this->error200('ユーザーデータを消去しました');
                    $users = json_encode($this->User->find('all', array(
                        'recursive' => -1
                    )));
                } else {
                    $error = $this->error400('データ消去に失敗しました');
                }
            } else {
                $error = $this->error404('指定されたuserは存在しません');
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }
        
        $this->set(compact('error', 'users'));
    }
}