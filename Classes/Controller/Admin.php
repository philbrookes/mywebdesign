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
    
    public function editForm(\Request $req, \Response $res) {
        $admin = new \Model\Admin($req->param("id"));
        $view = new \Output\View("admin/edit");
        $view->formHandler = "Controller\Admin::editAdmin";
        $view->admin = $admin;
        $view->title = "Edit Admin";
        $res->addView("content", $view);
    }
    
    public function editAdmin(\Request $req, \Response $res) {
        $admin = new \Model\Admin($req->param("id"));
        $admin = $this->_populateAdminFromRequest($admin, $req, "Controller\\Admin::editForm");
        $admin->write();
        header("location: " . \Router::controllerUrl("Controller\Admin::listAdmin"));
    }
    
    public function createForm(\Request $req, \Response $res) {
        $admin = new \Model\Admin();
        $view = new \Output\View("admin/edit");
        $view->formHandler = "Controller\Admin::createAdmin";
        $view->admin = $admin;
        $view->title = "Create Admin";
        $res->addView("content", $view);
    }
    
    public function createAdmin(\Request $req, \Response $res) {
        $admin = new \Model\Admin();
        $admin = $this->_populateAdminFromRequest($admin, $req, "Controller\\Admin::createForm");
        $admin->write();
        \Response::RedirectTo("Controller\Admin::listAdmin", array(), "Admin created");
    }
    
    public function deleteAdmin(\Request $req, \Response $res) {
        $admin = new \Model\Admin($req->param("id"));
        $admin->deleteFromDb();
        \Response::RedirectTo("Controller\Admin::listAdmin", array(), "Admin '{$admin->username}' deleted");
    }
    
    private function _populateAdminFromRequest(\Model\Admin $admin, \Request $req, $handler) {
        if(! $admin->checkUsername($req->username)) {
            \Response::RedirectTo(
                $handler, 
                array("id" => $req->param("id")), 
                "username in use!"
            );
        }
        if(($req->password != "" || $req->confirmPassword != "") && $req->password != $req->confirmPassword){
            \Response::RedirectTo(
                $handler, 
                array("id" => $req->param("id")), 
                "Password must match confirm password!"
            );
        } 
        
        $admin->username = $req->username;
        $admin->email = $req->email;
        $admin->password = md5($req->password);
        
        return $admin;
    }
    
    
}
