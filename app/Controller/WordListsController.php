<?php

class WordListsController extends AppController{
    public $name = 'WordLists';
    public $uses = array('ListUser', 'User', 'Word', 'WordList');
    public $layout = 'json';
    
    public function create() {
        $error = json_encode(array());
        $word_list = json_encode(array());
        
        if($this->request->is('post')){
            //ユーザーの存在をチェック
            $this->User->id = $this->request->data['WordList']['owner_id'];
            if($this->User->exists()){
                if($this->WordList->save($this->request->data)){
                    $tmp_list = $this->WordList->get_latest_list($this->WordList->getLastInsertId());
                    //lists_usersに格納するデータの生成
                    $list_user_data = $this->make_lists_data($tmp_list);
                    if($this->ListUser->save($list_user_data)) {
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
    
    public function make_lists_data($data){
        $list_data['ListUser']['list_id'] = $data['WordList']['id'];
        $list_data['ListUser']['user_id'] = $data['WordList']['owner_id'];
        
        return $list_data;
    }
}
