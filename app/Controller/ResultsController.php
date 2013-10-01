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

    public function change_status($word_id = NULL, $user_id = NULL) {
        $error = json_encode(array());
        $result = json_encode(array());

        $this->Word->id = $word_id;
        if ($this->Word->exists()) {                                                //単語の存在をチェック
            $this->User->id = $user_id;
            if ($this->User->exists()) {                                            //ユーザーの存在をチェック
                $result_array = $this->Result->find('first', array(
                    'conditions' => array('user_id' => $user_id, 'word_id' => $word_id),
                    'fields' => array('id', 'user_id', 'word_id', 'status'),
                    'recursive' => -1
                ));
                if ($result_array != NULL) {                                      //resultの存在をチェック
                    if ($this->request->is('post')) {
                        $result_id = $result_array['Result']['id'];
                        $this->Result->id = $result_id;                             //プライマリーキーをセットして更新
                        if ($this->Result->save($this->request->data)) {
                            $error = $this->error200('データを更新しました');
                            $result = json_encode($this->Result->findById($result_id, NULL, NULL, -1));
                        } else {
                            $error = $this->error400('データの更新に失敗しました');
                        }
                    } else {
                        $result = json_encode($result_array);
                        $error = $this->error200('現在のこの問題の結果');
                    }
                } else {
                    $error = $this->error404('この単語の結果はまだ作られていません');
                }
            } else {
                $error = $this->error404('指定された単語は存在しません');
            }
        } else {
            $error = $this->error404('指定された単語は存在しません');
        }

        $this->set(compact('error', 'result', 'result_array'));
    }

}
