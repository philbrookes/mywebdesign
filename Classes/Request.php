<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author phil
 */
class Request {
    private $_params;
    public function __construct($requestData) {
        $this->req = $requestData;
        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata, true);
        if(sizeof($data)){
            $this->req = array_merge($this->req, $data);
        }
    }
    
    public function __get($name) {
        if(isset($this->req[$name])) {
            return $this->req[$name];
        }
        
        return null;
    }
    
    public function setParams(array $params) {
        $this->_params = $params;
    }
    
    public function param($name) {
        if(isset($this->_params[$name])){
            return $this->_params[$name];
        }
        return null;
    }
    
    public static function popErrorMessages(){
        if(!isset($_SESSION['errors'])){
            return array();
        }
        $messages = $_SESSION['errors'];
        $_SESSION['errors'] = array();
        return $messages;
    }
    
    public function getRequestedUri(){
        return $_SERVER['REQUEST_URI'];
    }
    
    public function getRequestMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }
}
