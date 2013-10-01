<?php

class FavoritesController extends AppController {

    public $name = 'Favorites';
    public $uses = array('Favorite', 'User', 'Word');
    public $layout = 'json';

    public function register() {
        $favorite = json_encode(array());
        $error = json_encode(array());

        if ($this->request->is('post')) {
            $this->User->id = $this->request->data['Favorite']['user_id'];
            if ($this->User->exists()) {
                $this->Word->id = $this->request->data['Favorite']['word_id'];
                if ($this->Word->exists()) {
                    $already_favorite = $this->Favorite->find('first', array(
                        'conditions' => array(
                            'Favorite.user_id' => $this->request->data['Favorite']['user_id'],
                            'Favorite.word_id' => $this->request->data['Favorite']['word_id']
                        ),
                        'recursive' => -1
                        )
                    );

                    if ($already_favorite == NULL) {
                        if ($this->Favorite->save($this->request->data)) {
                            $error = $this->error200('お気に入りに登録しました');
                            $favorite = json_encode($this->Favorite->findById($this->Favorite->getLastInsertId(), NULL, NULL, -1));
                        } else {
                            $error = $this->error400('お気に入り登録に失敗しました');
                        }
                    } else {
                        $error = $this->error403('すでにお気に入りに登録されています');
                        $favorite = json_encode($already_favorite);
                    }
                } else {
                    $error = $this->error404('指定された単語は存在しません');
                }
            } else {
                $error = $this->error404('指定されたユーザーは存在しません');
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }

        $this->set(compact('error', 'favorite'));
    }

}
