<?php

class User extends AppModel {

    public $name = 'User';
    public $hasMany = array(
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

    //user_idの
    public function get_specify_user($user_id = NULL) {
        $user = $this->find('first', array(
            'conditions' => array('User.id' => $user_id),
            'fields' => array('id', 'username', 'screen_name'),
            //ProfileはhasOneなテーブル
            'recursive' => -1
        ));

        return $user;
    }

    public function hash_password($req_password = NULL) {
        $hashed_password = hash('md5', $req_password);
        return $hashed_password;
    }

    public function username_already_used($req_username = NULL) {
        $user = $this->find('first', array(
            'conditions' => array('User.username' => $req_username),
            'recursive' => -1
        ));

        if ($user == NULL) {
            return false;
        } else {
            return true;
        }
    }

    public function make_profile($user_id = NULL) {
        $profile = array(
            'user_id' => $user_id
        );

        return $profile;
    }

}
