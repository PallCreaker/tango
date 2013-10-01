<?php

class Result extends AppModel{
    public $name = 'Result';
    public $useTable = 'results';
    
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Word' => array(
            'className' => 'Word',
            'foreignKey' => 'word_id',
            'dependent' => true
        )
    );
}
