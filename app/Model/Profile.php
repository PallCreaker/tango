<?php

class Profile extends AppModel {
    public $name = 'Profile';
    
    public function get_user_profile($user_id = null) {
        $this->Profile->user_id = $user_id;
        $profile = $this->find('first', array(
            'conditions' => array('User.id' => $user_id),
            'fields' => array('user_id', 'color_id', 'message'),
            'recursive' => -1
        ));
        
        return $profile;
    }
}
