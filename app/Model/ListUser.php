<?php

class ListUser extends AppModel {
    public $name = 'ListUser';
    public $useTable = 'lists_users';


    public $hasMany = array(
        //foreignKeyがよくわからん
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    
    public $belongsTo = array(
        //foreignKeyがよくわからん
        'WordList' => array(
            'className' => 'WordList',
            'foreignKey' => 'list_id',
            'dependent' => true
        )
    );

}
