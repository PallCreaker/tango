<?php

class User extends AppModel {

    public $name = 'User';
    public $hasMany = array(
        'Friend' => array(
            'className' => 'Friend',
            'foreignKey' => 'user_id',
            'dependent' =>  true
        ),
        'List_User' => array(
            'className' => 'List_User',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Result' => array(
            'className' => 'Result',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Favorite' => array(
            'className' => 'Favorite',
            'foreignKey' => 'user_id',
            'dependent' => true
        )
    );
    
    public $hasOne = array(
        'Profile' => array(
            'className' => 'Profile',
            'foreignKey' => 'user_id',
            'dependent' => true
        )
    );
    
    public function get_specify_user($user_id) {
        $user = $this->find('first', array(
            'conditions' => array('User.id' => $user_id),
            'fields' => array('id', 'username', 'screen_name'),
            'recursive' => -1
        ));
        
        return $user;
    }
}