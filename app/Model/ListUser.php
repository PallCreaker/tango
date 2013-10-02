<?php

class ListUser extends AppModel {
    public $name = 'ListUser';
    public $useTable = 'lists_users';

    public $belongsTo = array(
        'WordList' => array(
            'className' => 'WordList',
            'foreignKey' => 'list_id',
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    
    public function already_friend($friend_request = NULL) {
        $friend_data = $this->findByUserIdAndListId($friend_request['ListUser']['user_id'], $friend_request['ListUser']['list_id']);
        
        if($friend_data == NULL){
            return FALSE;
        } else {
            return true;
        }
    }

}
