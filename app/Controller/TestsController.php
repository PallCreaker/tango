<?php

class TestsController extends AppController {

    public $name = 'Tests';
    public $uses = array('User');
    public $layout = 'default';

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function user_add() {
        
    }
}