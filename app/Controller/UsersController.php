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
        if ($this->request->is('post')) {
            $this->request->data['User']['password'] = hash('md5', $this->request->data['User']['password']);
            if ($this->User->save($this->request->data)) {
                //登録したユーザーの情報を配列で返す
                $user = $this->User->get_specify_user($this->User->getLastInsertID());
                //ユーザーIDをprofilesにしまう
                $profile = array(
                    'user_id' => $user['User']['id']
                );

                if ($this->Profile->save($profile)) {
                    echo 'プロフィールにもidをしまいました';
                } else {
                    echo 'プロフィールにidをしまうのをみすりました';
                }
                //最後にユーザー情報をJSONで返す
                if ($user != null) {
                    $this->set('user', json_encode($user));
                } else {
                    echo '$userが空です';
                }
            } else {
                echo 'ユーザー情報を保存できませんでした';
            }
        } else {
            echo 'リクエストがPOSTではありません';
        }
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