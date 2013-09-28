<?php

class Friend extends AppModel {
    public $name = 'Friend';
    
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => array('user_id1', 'user_id2'),
            'dependent' => true
        )
    );

    public function get_specify_pair($id = NULL) {
       $pair = $this->find('first', array(
            'conditions' => array('Friend.id' => $id),
            'fields' => array('user_id1', 'user_id2'),
            'recursive' => 0
        ));

        return $pair;
    }
}

