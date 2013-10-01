<?php

class Favorite extends AppModel {
    public $name = 'Favorite';
    public $useTable = 'favorites';
    
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            //'dependent' => true
        ),
        'Word' => array(
            'className' => 'Word',
            'foreignKey' => 'word_id',
           // 'dependent' => true
        )
    );
}
