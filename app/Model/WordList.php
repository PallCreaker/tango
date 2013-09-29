<?php

class WordList extends AppModel {
    public $name = 'WordList';
    public $useTable = 'word_lists';
    
    public $hasOne = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'id',
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
    
    public function get_latest_list($list_id = NULL) {
        $list = $this->find('first', array(
            'conditions' => array('WordList.id' => $list_id),
            'fields' => array('id', 'owner_id', 'title', 'description'),
        ));
        
        return $list;
    }

}
