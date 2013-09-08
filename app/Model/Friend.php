<?php

class Friend extends AppModel {
    public $name = 'Friend';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => array('User.id' => 'Friend.user_id1'),
        )
    );
    
    public function get_friends_list($user_id) {
        $friends_list = $this->find('all', array(
            'conditions' => array('Friend.user_id1' => $user_id),
            'fields' => array('id', 'username', 'screen_name'),
            'recursive' => -1
        ));
        
        return $friends_list;
    }
}

