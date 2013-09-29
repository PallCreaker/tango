<?php

class WordsController extends AppController{
    public $name = 'Words';
    public $uses = array('Word', 'Result', 'Favorite');
    public $layout = 'json';
}
