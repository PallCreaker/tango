<?php

class WordListsController extends AppController {

    public $name = 'WordLists';
    public $uses = array('ListUser', 'User', 'Word', 'WordList');
    public $layout = 'json';

    public function create() {
        $error = json_encode(array());
        $word_list = json_encode(array());

        if ($this->request->is('post')) {
            //ユーザーの存在をチェック
            $this->User->id = $this->request->data['WordList']['owner_id'];
            if ($this->User->exists()) {
                if ($this->WordList->save($this->request->data)) {
                    $tmp_list = $this->WordList->get_latest_list($this->WordList->getLastInsertId());
                    //lists_usersに格納するデータの生成
                    $list_user_data = $this->make_lists_data($tmp_list);
                    if ($this->ListUser->save($list_user_data)) {
                        $word_list = json_encode($tmp_list);
                        $error = $this->error200('success');
                    } else {
                        $error = $this->error400('データ保存に失敗しました');
                    }
                } else {
                    $error = $this->error400('データ保存に失敗しました');
                }
            } else {
                $error = $this->error404('指定されたユーザーは存在しません');
            }
        } else {
            $error = $this->error400('リクエストの形式が適切ではありません');
        }

        $this->set(compact('error', 'word_list'));
    }

    public function make_lists_data($data) {
        $list_data['ListUser']['list_id'] = $data['WordList']['id'];
        $list_data['ListUser']['user_id'] = $data['WordList']['owner_id'];

        return $list_data;
    }

    public function delete($list_id = NULL) {
        $error = json_encode(array());
        $all_lists = json_encode(array());

        if ($this->request->is('get')) {
            $this->WordList->id = $list_id;
            $this->ListUser->list_id = $list_id;
            if ($this->WordList->exists() || $this->ListUser->exists()) {
                //WordList消去＝＞ListUserも消去されるはず
                if ($this->WordList->deleteAll(array('WordList.id' => $list_id))) {
                    $error = $this->error200('success');
                    $all_lists = json_encode($this->WordList->find('all'));
                } else {
                    $error = $this->error400('データ消去に失敗しました');
                    $all_lists = json_encode($this->WordList->find('all'));
                }
            } else {
                $error = $this->error404('指定された単語帳は存在しません');
                $all_lists = json_encode($this->WordList->find('all'));
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
            $all_lists = json_encode($this->WordList->find('all'));
        }
        //とりあえず、すべての単語帳を返す
        $this->set(compact('error', 'all_lists'));
    }

    public function get_words($list_id = NULL) {
        $error = json_encode(array());
        $all_words = json_encode(array());

        if ($this->request->is('get')) {
            $this->Word->list_id = $list_id;
            $all_words = json_encode($this->Word->findAllByListId($list_id));
            $error = $this->error200('success');
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }

        $this->set(compact('error', 'all_words'));
    }

    public function add_friend() {
        $error = json_encode(array());
        $added_friend = json_encode(array());

        if ($this->request->is('post')) {
            $friend_req['ListUser']['user_id'] = $this->request->data['WordList']['user_id'];
            $friend_req['ListUser']['list_id'] = $this->request->data['WordList']['list_id'];

            $this->User->id = $friend_req['ListUser']['user_id'];
            if ($this->User->exists()) {
                $this->WordList->id = $friend_req['ListUser']['list_id'];
                if ($this->WordList->exists()) {
                    if ($this->ListUser->already_friend($friend_req) == false) {
                        if ($this->ListUser->save($friend_req)) {
                            $error = $this->error200('友達を追加しました');
                            $added_friend = json_encode($this->ListUser->findById($this->ListUser->getLastInsertId(), NULL, NULL, -1));
                        } else {
                            $error = $this->error400('友達を追加できませんでした');
                        }
                    } else {
                        $error = $this->error403('既に友達です');
                        $added_friend = json_encode($this->ListUser->findByUserIdAndListId($friend_req['ListUser']['user_id'], $friend_req['ListUser']['list_id']));
                    }
                } else {
                    $error = $this->error404('指定された単語帳は存在しません');
                }
            } else {
                $error = $this->error404('指定されたユーザーは存在しません');
            }
        } else {
            $error = $this->error403('リクエストの形式が適切ではありません');
        }

        $this->set(compact('error', 'added_friend'));
    }

}
