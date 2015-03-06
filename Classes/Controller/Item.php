<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Controller;
/**
 * Description of Item
 *
 * @author phil
 */
class Item extends AbAuthController{
    public function createForm(\Request $req, \Response $res){
        $customer = new \Model\Customer($req->param("customer_id"));
        $item = new \Model\Item();
        $view = new \Output\View("item/edit");
        $view->handler = "Controller\Product::createItem";
        $view->customer = $customer;
        $view->item = $item;
        $view->title = "Create item for " . $customer->getFullName();
        $res->addView("content", $view);
    }
    
    public function createItem(\Request $req, \Response $res){
        $item = new \Model\Item();
        $item->customer_id = $req->customer_id;
        $item->name = $req->name;
        $item->product_id = $req->product_id;
        $item->next_bill_date = $req->next_bill_date;
        $item->write();
        $res->RedirectTo(
            "Controller\Customer::viewCustomer", 
            array("id" => $req->param('customer_id')), 
            "New item created!"
        );
    }
    
    public function deleteItem(\Request $req, \Response $res){
        $item = new \Model\Item($req->param("item_id"));
        
        $item->deleteFromDb();
        $res->RedirectTo(
            "Controller\Customer::viewCustomer", 
            array("id" => $req->param('customer_id')), 
            "deleted " . $item->name
        );
    }
    
    public function editForm(\Request $req, \Response $res){
        $item = new \Model\Item($req->param("item_id"));
        $customer = new \Model\Customer($req->param("customer_id"));
        $view = new \Output\View("item/edit");
        $view->handler = "Controller\Product::editItem";
        $view->item = $item;
        $view->customer = $customer;
        $res->addView("content", $view);
    }
    
    public function editItem(\Request $req, \Response $res){
        $item = new \Model\Item($req->param("item_id"));
        $item->name = $req->name;
        $item->product_id = $req->product_id;
        $item->next_bill_date = $req->next_bill_date;
        $item->write();
        $res->RedirectTo(
            "Controller\Customer::viewCustomer", 
            array("id" => $req->param('customer_id')), 
            $item->name . " edited"
        );
    }
}
