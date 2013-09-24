<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public function beforeFilter() {
    
    }
    
    public $components = array('DebugKit.Toolbar', 'Session');
    public $helpers = array('Form', 'Html', 'Js', 'Time');
    
    public function error404($description) {
        $error = array(
            'code' => 404,
            'data' => array(
                'text' => 'Not Found',
                'description' => $description
            )
        );
        return $error;
    }
    
    public function error500($description) {
        $error = array(
            'code' => 500,
            'data' => array(
                'text' => 'Internal Server Error',
                'description' => $description
            )
        );        
        return $error;
    }
    
    public function error400($description) {
        $error = array(
            'code' => 400,
            'data' => array(
                'text' => 'Bad Request',
                'description' => $description
            )
        );        
        return $error;
    }
    
    public function error401($description) {
        $error = array(
            'code' => 401,
            'data' => array(
                'text' => 'Unauthorized',
                'description' => $description
            )
        );        
        return $error;
    }
    
    public function error403($description) {
        $error = array(
            'code' => 403,
            'data' => array(
                'text' => 'Forbidden',
                'description' => $description
            )
        );        
        return $error;
    }
    
    public function error200($description) {
        $error = array(
            'code' => 200,
            'data' => array(
                'text' => 'OK',
                'description' => $description
            )
        );        
        return $error;
    }
}
