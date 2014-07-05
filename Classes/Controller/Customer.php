<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Controller;
/**
 * Description of Customer
 *
 * @author phil
 */
class Customer extends AbAuthController{
    public function viewCustomer(\Request $req, \Response $res){
        $customer = new \Model\Customer($req->param("id"));
        $view = new \Output\View("customer/details");
        $view->customer = $customer;
        $res->addView("content", $view);
    }
    
    public function listCustomer(\Request $req, \Response $res){
        $customer = new \Model\Customer();
        $customers = $customer->fetchAll();
        $view = new \Output\View("customer/list");
        $view->customers = $customers;
        $res->addView("content", $view);
    }
    
    public function editForm(\Request $req, \Response $res) {
        $customer = new \Model\Customer($req->param("id"));
        $view = new \Output\View("customer/edit");
        $view->formHandler = "Controller\Customer::editCustomer";
        $view->customer = $customer;
        $view->title = "Edit Customer";
        $res->addView("content", $view);
    }
    
    public function editCustomer(\Request $req, \Response $res) {
        $customer = new \Model\Customer($req->param("id"));
        $customer = $this->_populateCustomerFromRequest($customer, $req, "Controller\\Customer::editForm");
        $customer->write();
        header("location: " . \Router::controllerUrl("Controller\Customer::listCustomer"));
    }
    
    public function createForm(\Request $req, \Response $res) {
        $customer = new \Model\Customer();
        $view = new \Output\View("customer/edit");
        $view->formHandler = "Controller\Customer::createCustomer";
        $view->customer = $customer;
        $view->title = "Create Customer";
        $res->addView("content", $view);
    }
    
    public function createCustomer(\Request $req, \Response $res) {
        $customer = new \Model\Customer();
        $customer = $this->_populateCustomerFromRequest($customer, $req, "Controller\\Customer::createForm");
        $customer->write();
        \Response::RedirectTo("Controller\Customer::listCustomer", array(), "Customer created");
    }
    
    public function deleteCustomer(\Request $req, \Response $res) {
        $customer = new \Model\Customer($req->param("id"));
        $customer->deleteFromDb();
        \Response::RedirectTo("Controller\Customer::listCustomer", array(), "Customer '{$customer->username}' deleted");
    }
    
    private function _populateCustomerFromRequest(\Model\Customer $customer, \Request $req, $handler) {
        $customer->first_name = $req->firstname;
        $customer->last_name = $req->lastname;
        $customer->email = $req->email;
        return $customer;
    }
    
    
}
