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
    
    public function checkLogin(\Request $req, \Response $res){
        //check if login is required first.
        $auth = new \Authentication\Auth();

        if(! $auth->isLoggedIn()){
            $res->json(array("flash" => "You must login!"), "401");
        } 
    }
}
