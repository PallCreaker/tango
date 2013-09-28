<?php

class FriendsController extends AppController {

    public $name = 'Friends';
    public $uses = array('Friend', 'User');
    public $layout = 'json';

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function add() {
        $friend = json_encode(array());
        $error = json_encode(array());
        $req_user1 = $this->request->data['Friend']['user_id1'];
        $req_user2 = $this->request->data['Friend']['user_id2'];
        
        if ($this->request->is('post')) {
            $this->User->id = $req_user1;
            if ($this->User->exists()) {
                $this->User->id = $req_user2;
                if ($this->User->exists()) {
                    $friend = $this->Friend->find('first', array(
                                'conditions' => array(
                                    'OR' => array(
                                        array(
                                            'Friend.user_id1' => $req_user1,
                                            'Friend.user_id2' => $req_user2
                                        ),
                                        array(
                                            'Friend.user_id1' => $req_user2,
                                            'Friend.user_id2' => $req_user1
                                        )
                                    )
                        )));
                    
                    if($friend == NULL) {
                        if($this->Friend->save($this->request->data)){
                            $error = $this->error200('success');
                            $friend = json_encode($this->Friend->get_specify_pair($this->Friend->getLastInsertID()));
                        }
                    } else {
                        $friend = json_encode($friend);
                        $error = $this->error400('このユーザーは既に友達です');
                    }
                } else {
                    $error = $this->error404('指定されたユーザーは存在しません');
                }
            } else {
                $error = $this->error404('指定されたユーザーは存在しません');
            }
        } else {
            $error = $this->error400('適切なリクエストではありません');
        }

        //エラーコードと追加された友達を返す
        $this->set(compact('error', 'friend'));
    }

    public function get_all_friends($user_id = NULL) {
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

        if (json_decode($friends) == NULL) {
            $error = $this->error404('まだ友達はいません');
            $this->set(compact('error', 'friends'));
        } else {
            $error = $this->error200('success');
            $this->set(compact('friends', 'error'));
        }
    }

}
