<?php

class ListsController extends AppController{
    public $name = 'Lists';
    public $uses = array('ListUser', 'User', 'Word');
    
    
}
