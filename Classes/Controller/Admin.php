<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Controller;
/**
 * Description of Admin
 *
 * @author phil
 */
class Admin extends AbAuthController{
    public function getAdmins(\Request $req, \Response $res){
        $admin = new \Model\Admin();
        $admins = $admin->fetchAll();
        $result = Array();
        foreach($admins as $admin){
            $result[] = $admin->toArray(array("password"));
        }
        $res->Json($result);
    }
    public function getAdmin(\Request $req, \Response $res){
        $admin = new \Model\Admin();
        $admin->loadFromDb($req->param('id'));
        $res->Json($admin->toArray(array("password")));
    }
    
    public function editAdmin(\Request $req, \Response $res) {
        $admin = new \Model\Admin($req->param("id"));
        if($req->password != $req->confirm_password){
            $res->Json(array("flash" => "passwords must match!"), 500);
            return;
        }
        if(! $admin->checkUsername($req->username) ){
            $res->Json(array("flash" => "username taken"), 500);
            return;
        }
        $admin->username = $req->username;
        $admin->email = $req->email;
        
        if(strlen($req->password)){
            $admin->password = crypt($req->password);
        }
        
        $admin->write();
        $res->Json($admin->toArray(array("password")));
    }
    
    public function createAdmin(\Request $req, \Response $res) {
        $admin = new \Model\Admin();
        if($req->password != $req->confirm_password || ! strlen($req->password)){
            $res->Json(array("flash" => "passwords must have a value and match!"), 500);
            return;
        }
        if(! $admin->checkUsername($req->username) || ! strlen($req->username)){
            $res->Json(array("flash" => "invalid username"), 500);
            return;
        }
        $admin->username = $req->username;
        $admin->email = $req->email;
        
        if(strlen($req->password)){
            $admin->password = crypt($req->password);
        }
        
        $admin->write();
        $res->Json($admin->toArray(array("password")));
    }
    
    public function deleteAdmin(\Request $req, \Response $res) {
        $admin = new \Model\Admin($req->param("id"));
        $admin->deleteFromDb();
        $res->Json(array("message" => "Admin successfully deleted"));
    }
}
