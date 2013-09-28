<?php

class ListModel extends AppModel {
    public $name = 'List';
    
    public $hasOne = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'owner_id',
            'dependent' => true
        )
    );
    
    public $hasMany = array(
        'ListUser' => array(
            'className' => 'ListUser',
            'foreignKey' => 'list_id',
        ),
        
        'Word' => array(
            'className' => 'Word',
            'foreignKey' => 'list_id'
        )
    );

}
