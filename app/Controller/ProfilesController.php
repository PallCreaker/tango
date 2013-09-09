<?php

class ProfilesController extends AppController {
    public $name = 'Profiles';
    public $uses = array('Profile');
    public $layout = 'json';
    
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'dependent' => true
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function edit ($user_id = null) {
        $this->Profile->user_id = $user_id;
        if ($this->request->is('post') && $this->Profile->exists()) {
            if ($this->Profile->save(json_decode($this->request->data))) {
                echo 'プロフィールが正しく更新されました!';
                $profile = $this->Profile->get_user_profile($user_id);
                $this->set('profile', $profile);
            }
        } else {
            $profile = array('hoge' => 'hoge');
            $this->set('profile', json_encode($profile));
            echo '指定されたユーザーは存在しません。';
        }
    }
}
