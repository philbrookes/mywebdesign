<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Controller;
/**
 * Description of AbAuthController
 *
 * @author phil
 */
class AbAuthController extends AbController{
    public function __construct(){
        //check if login is required first.
        $auth = new \Authentication\Login();

        if(! $auth->isLoggedIn()){
            $controller = new \Controller\Login();
            echo $controller->LoginForm();
            exit;
        } 
    }
}
