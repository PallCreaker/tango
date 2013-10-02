<?php

class User extends AppModel {

    public $name = 'User';
    public $hasMany = array(
//        'Friend' => array(
//            'className' => 'Friend',
//            'foreignKey' => array('user_id1', 'user_id2'),
//            'dependent' => true
//        ),
        'ListUser' => array(
            'className' => 'ListUser',
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
            //ProfileはhasOneなテーブル
            'recursive' => 0
        ));

        return $user;
    }
    
    public function user_already($username = NULL) {
        $user = $this->find('first', array(
            'conditions' => array('User.username' => $username),
            'recursive' => -1
        ));
        
        if($user == NULL){
            return false;
        } else {
            return true;
        }
    }
}
