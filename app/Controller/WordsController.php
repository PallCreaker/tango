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

}
