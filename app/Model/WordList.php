<?php

class WordList extends AppModel {
    public $name = 'WordList';
    public $useTable = 'word_lists';
    
    public $hasOne = array(
//        'User' => array(
//            'className' => 'User',
//            'foreignKey' => 'id'
//        )
    );
    
    public $hasMany = array(
        //WordListは中間テーブルListUserを持っていて、WordListが削除されるとListUserも削除される
        'ListUser' => array(
            'className' => 'ListUser',
            'foreignKey' => 'list_id',
            'dependent' => true
        ),
        //WordListはWordをたくさん持っていて、WordListが削除されるとWordも削除される
        'Word' => array(
            'className' => 'Word',
            'foreignKey' => 'list_id',
            'dependent' => true
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
