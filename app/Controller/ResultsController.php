<?php

class ResultsController extends AppController {

    public $name = 'Results';
    public $uses = array('Result', 'Word', 'User');
    public $layout = 'json';

    public function register() {
        $result = json_encode(array());
        $error = json_encode(array());

        if ($this->request->is('post')) {
            $req_word = $this->request->data['Result']['word_id'];
            $this->Word->id = $req_word;
            if ($this->Word->exists()) {
                $req_user = $this->request->data['Result']['user_id'];
                $this->User->id = $req_user;
                if ($this->User->exists()) {
                    //user_idとword_idの組が同じ時はだめ
                    if ($this->Result->findByUserIdAndWordId($req_user, $req_word) == NULL) {
                        if ($this->Result->save($this->request->data)) {
                            $error = $this->error200('結果を更新しました');
                            $result = json_encode($this->Result->findById($this->Result->getLastInsertId(), NULL, //fields
                                            NULL, //order
                                            -1       //recursive
                            ));
                        } else {
                            $error = $this->error400('結果の保存に失敗しました');
                        }
                    } else {
                        $error = $this->error403('既に同じ結果が登録されています');
                    }
                } else {
                    $error = $this->error404('指定された単語は存在しません');
                }
            } else {
                $error = $this->error404('指定された単語は存在しません');
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }

        $this->set(compact('result', 'error'));
    }

}
