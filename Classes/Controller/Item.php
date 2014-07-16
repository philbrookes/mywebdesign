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
    public function getItem(\Request $req, \Response $res){
        $item = new \Model\Item();
        $item->loadFromDb($req->param('id'));
        $res->Json($item->toArray());
    }
    
    public function editItem(\Request $req, \Response $res){
        $item = new \Model\Item($req->param("id"));
        $item->name = $req->name;
        $item->product_id = $req->product_id;
        $item->next_bill_date = $req->next_bill_date;
        $item->write();
        $res->Json($item->toArray());
    }
    
    public function createItem(\Request $req, \Response $res){
        $item = new \Model\Item();
        $item->customer_id = $req->customer_id;
        $item->name = $req->name;
        $item->product_id = $req->product_id;
        $item->next_bill_date = $req->next_bill_date;
        $item->write();
        $res->Json($item->toArray());
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
}
