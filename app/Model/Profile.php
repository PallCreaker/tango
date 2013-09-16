<?php

class Profile extends AppModel {
    public $name = 'Profile';
    
    public function get_user_profile($profile_id = null) {
    //    $this->Profile->user_id = $user_id;
        $profile = $this->find('first', array(
            'conditions' => array('Profile.id' => $profile_id),
            'fields' => array('id', 'user_id', 'color_id', 'message'),
            'recursive' => -1
        ));
        
        return $profile;
    }
}
