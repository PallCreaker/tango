<?php

class ListUser extends AppModel {
    public $name = 'ListUser';
    
    public $hasMany = array(
        //foreignKeyがよくわからん
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'dependent' => true
        )
    );
    
    public $belongsTo = array(
        //foreignKeyがよくわからん
        'List' => array(
            'className' => 'List',
            'foreignKey' => 'list_id',
            'dependent' => true
        )
    );

}
