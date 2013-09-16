<?php

class Friend extends AppModel {
    public $name = 'Friend';

//    public function get_friends_list($user_id) {
//        $friends_list = $this->find(
//                'all',
//                array(
//                    'conditions' => array('Friend.user_id1' => $user_id),
//                    'fields' => array('id', 'username', 'screen_name'),
//                    'recursive' => -1
//                )
//        );
//
//        return $friends_list;
//    }
    
    public function get_specify_friends($id = null) {
        $friends = $this->find('first', array(
            'conditions' => array('Friend.id' => $id),
            'fields' => array('user_id1', 'user_id2'),
            'recursive' => 2
        ));
        
        return $friends;
    }
    
    public function check_already_friends($friends_pair_id = null){
        
    }

}

