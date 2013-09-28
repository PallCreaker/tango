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
        if ($this->request->is('post')) {
            $this->User->id = $this->request->data['Friend']['user_id1'];
            if ($this->User->exists()) {
                $this->User->id = $this->request->data['Friend']['user_id2'];
                if ($this->User->exists()) {
                    $friend = $this->Friend->find('first', array(
                                'conditions' => array(
                                    'OR' => array(
                                        array(
                                            'Friend.user_id1' => $this->request->data['Friend']['user_id1'],
                                            'Friend.user_id2' => $this->request->data['Friend']['user_id2']
                                        ),
                                        array(
                                            'Friend.user_id1' => $this->request->data['Friend']['user_id2'],
                                            'Friend.user_id2' => $this->request->data['Friend']['user_id1']
                                        )
                                    )
                        )));
                        debug($friend);
                    
                    if($friend == NULL) {
                        if($this->Friend->save($this->request->data)){
                            $error = json_encode($this->error200('success'));
                            $friend = json_encode($this->Friend->get_specify_pair($this->Friend->getLastInsertID()));
                        }
                    } else {
                        $friend = json_encode($friend);
                        $error = json_encode($this->error400('このユーザーは既に友達です'));
                    }
                } else {
                    $error = json_encode($this->error404('指定されたユーザーは存在しません'));
                }
            } else {
                $error = json_encode($this->error404('指定されたユーザーは存在しません'));
            }
        } else {
            $error = json_encode($this->error400('適切なリクエストではありません'));
        }

        //エラーコードと追加された友達を返す
        $this->set(compact('error', 'friend'));
    }

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
            $error = json_encode($this->error404('まだ友達はいません'));
            $this->set(compact('error'));
        } else {
            $error = json_encode($this->error200('success'));
            $this->set(compact('friends', 'error'));
        }
    }

}
