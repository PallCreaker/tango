<?php

class User extends AppModel {

    public $name = 'User';
//    public $hasMany = array(
//        'FriendsRequest' => array(
//            'className' => 'FriendsRequest',
//            'foreignKey' => 'user_id',
//            'dependent' =>  true
//        )
//    );
//    
    public function get_specify_user($user_id) {
        $user = $this->find('first', array(
            'conditions' => array('User.id' => $user_id),
            'fields' => array('id', 'username', 'screen_name'),
            'recursive' => -1
        ));
        
        return $user;
    }
}