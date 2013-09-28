<?php

class FriendsController extends AppController {
    public $name = 'Friends';
    public $uses = array('Friend', 'User');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
//    public function add() {
//        if($this->request->is('post')){
//            if($this->Friend->save($this->request->data)){
//                $friends = $this->Friend->get_specify_friends($this->Friend->getLastInsertID());
//                $this->set('friends', json_encode($friends));
//            }  else {
//                //todo 既に友達になっている時のエラー処理
//            }
//        }else{
//          //  $this->Session->setFlash('リクエストがポストではありません');
//        }
//    }
    
//    public function get_friends($user_id = null) {
//        $this->Friend->user_id1 = $user_id;
//        if($this->request->is('post')) {
//            $friends_list = json_encode($this->Friend->get_friends_list($user_id));
//            $this->set('friends_list', $friends_list);
//        } else {
//            $error = json_encode($this->error404('指定された友達がいません'));
//            $this->set('error', $error);
//        }
//    }
    
    public function get_all_friends($user_id = NULL){
        $friends = json_encode($this->Friend->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Friend.user_id1' => $user_id,
                    'Friend.user_id2' => $user_id
                )
            ),
            //新しい友達から順番に取得
            'order' => array(
                'Friend.created' => 'DESC'
            ))));

        if(json_decode($friends) == NULL){
            $error = json_encode($this->error404('まだ友達はいません'));
            $this->set(compact('error'));
        }  else {
            $error = json_encode($this->error200('success'));
            $this->set(compact('friends', 'error'));
        }
    }
}
