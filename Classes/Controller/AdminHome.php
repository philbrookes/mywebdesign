<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Controller;
/**
 * Description of AdminController
 *
 * @author phil
 */
class AdminHome extends \Controller\AbAuthController{
    public function getLinks(\Request $req, \Response $res){
        $links = array(
            array("name" => "Admins", "url" => \Router::controllerUrl("Controller\Admin::getAdmins")),
            array("name" => "Customers", "url" => \Router::controllerUrl("Controller\Customer::listCustomer")),
            array("name" => "Products", "url" => \Router::controllerUrl("Controller\Product::listProduct"))
        );
        $res->Json($links);
    }
    
}
