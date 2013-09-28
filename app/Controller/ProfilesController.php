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
            if($this->Profile->save($this->request->data)){
                $error = $this->error200('プロフィールが正しく更新されました');
            }  else {
                $error = $this->error400('プロフィールが正しく更新されませんでした');
            }
        }  else {
            $error = $this->error404('リクエストがPOSTではありません');
        }
        
        $profile = $this->Profile->get_user_profile($profile_id);
        $this->request->data = $profile;
        $this->set(compact('profile', 'error'));
    }
}