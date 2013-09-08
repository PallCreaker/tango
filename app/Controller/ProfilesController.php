<?php

class ProfilesController extends AppController {
    public $name = 'Profiles';
    public $uses = array('Profile', 'User');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function edit ($user_id = null) {
        $this->Profile->id = $user_id;
        if ($this->request->is('post') && $this->User->exists()) {
            if ($this->Profile->save(json_decode($this->request->data))) {
                echo 'プロフィールが正しく更新されました!';
            }
        } else {
            echo '指定されたユーザーは存在しません。';
        }
    }
}
