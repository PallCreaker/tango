<?php

class ProfilesController extends AppController {
    public $name = 'Profiles';
    public $uses = array('Profile', 'User');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function edit ($user_id = null) {
        $error = json_encode(array());
        $profile = json_encode(array());
        $this->User->id = $user_id;
        
        if($this->User->exists()){
            $profile_array = $this->Profile->findByUserId($user_id, NULL, NULL, -1);
            if($profile != NULL){
                if($this->request->is('post')){
                    $this->Profile->id = $profile_array['Profile']['id'];
                    if($this->Profile->save($this->request->data)){
                        $error = $this->error200('プロフィールを更新しました');
                        $profile = json_encode($this->Profile->findById($profile_array['Profile']['id'], NULL, NULL, -1));
                    } else {
                        $error = $this->error400('プロフィールの更新に失敗しました');
                        $profile = json_encode(array());
                    }
                } else {
                    $error = $this->error200('現在のあなたのプロフィールです');
                    $profile = json_encode($this->Profile->findById($profile_array['Profile']['id'], NULL, NULL, -1));
                }
            } else {
                $error = $this->error404('指定されたプロフィールは存在しません');
                $profile = json_encode(array());
            }
        } else {
            $error = $this->error404('指定されたユーザーは存在しません');
        }

        $this->set(compact('profile', 'error', 'profile_array'));
    }
}