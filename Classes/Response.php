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
    private $view, $json, $resCode = 201;
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
    
    public function Json($data, $resCode=201){
        $this->json = $data;
        $this->resCode = $resCode;
    }
    public function present() {
        http_response_code($this->resCode);
        if($this->json){
            header("Content-type: Application/json");
            return json_encode($this->json);            
        }
        return $this->view->render();
    }
}
