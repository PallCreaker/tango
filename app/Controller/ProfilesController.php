<?php

class ProfilesController extends AppController {
    public $name = 'Profiles';
    public $uses = array('Profile');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function edit ($profile_id = null) {
        //アプリ側からプロフィールidもらって指定
        $this->Profile->id = $profile_id;
        
        if($this->request->is('post')){
            $this->Profile->save($this->request->data);
        }
        
        $profile = $this->Profile->get_user_profile($profile_id);
        $this->request->data = $profile;
        $this->set('profile', $profile);
    }
}