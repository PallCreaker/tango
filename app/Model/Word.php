<?php

class Word extends AppModel {
    public $name = 'Word';
    public $useTable = 'words';
    
    public $hasMany = array(
        'Result' => array(
            'className' => 'Result',
            'foreignKey' => 'word_id',
            'dependent' => true
        ),
        'Favorite' => array(
            'className' => 'Favorite',
            'foreignKey' => 'word_id',
            'dependent' => true
        )
    ); 
}
