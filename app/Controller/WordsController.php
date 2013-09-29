<?php

class WordsController extends AppController {

    public $name = 'Words';
    public $uses = array('Word', 'Result', 'Favorite', 'WordList');
    public $layout = 'json';

    public function add() {
        $error = json_encode(array());
        $word = json_encode(array());

        if ($this->request->is('post')) {
            $this->WordList->id = $this->request->data['Word']['list_id'];
            if ($this->WordList->exists()) {
                if ($this->Word->save($this->request->data)) {
                    $error = $this->error200('success');
                    $word = json_encode($this->Word->findById($this->Word->getLastInsertId()));
                } else {
                    $error = $this->error400('データの保存に失敗しました');
                }
            } else {
                $error = $this->error404('指定されたWordListは存在しません');
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }

        $this->set(compact('error', 'word'));
    }
    
    public function delete($word_id = NULL){
        $error = json_encode(array());
        $all_words = json_encode(array());
        
        if($this->request->is('get')){
            $this->Word->id = $word_id;
            if($this->Word->exists()){
                if($this->Word->delete($word_id)){
                    $error = $this->error200('success');
                    $all_words = json_encode($this->Word->find('all', array(
                        'recursive' => -1
                    )));
                } else {
                    $error = $this->error400('データ消去に失敗しました');
                }
            } else {
                $error = $this->error404('指定されたwordは存在しません');
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }
        
        $this->set(compact('error', 'all_words'));
    }
}
