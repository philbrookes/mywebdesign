<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author phil
 */
class Response {
    private $view;
    public function __construct(Output\View $view) {
        $this->view = $view;
    }
    
    public function addView($tag, Output\View $view) {
        $this->view->$tag = $view;
    }
    
    public static function addErrorMessage($message){
        $_SESSION['errors'][] = $message;
    }
    
    public static function RedirectTo($controllerMethod, Array $params = array(), $error = null){
        if(!is_null($error)){
            self::addErrorMessage($error);
        }
        header("Location: " . \Router::controllerUrl($controllerMethod, $params));
        exit;
    }
    
    public function present() {
        return $this->view->render();
    }
}
