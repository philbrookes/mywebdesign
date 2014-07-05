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
    public function getCustomer(\Request $req, \Response $res){
        $customer = new \Model\Customer($req->param("id"));
        $paidInvoices = $customer->getPaidInvoices();
        $dueInvoices = $customer->getUnpaidInvoices();
        
        $result = $customer->toArray();
        foreach($customer->getItems() as $item){
             $resItem = $item->toArray();
             $resItem['price'] = $item->getProduct()->price;
             $result['items'][] = $resItem;
        }
        foreach($customer->getUnpaidInvoices() as $invoice){
            $result['invoices']['unpaid'][] = $invoice->toArray();
        }
        foreach($customer->getPaidInvoices() as $invoice){
            $result['invoices']['paid'][] = $invoice->toArray();
        }
        
        $res->Json($result);
    }
    
    public function getCustomers(\Request $req, \Response $res){
        $customer = new \Model\Customer();
        $customers = $customer->fetchAll();
        $result = Array();
        foreach($customers as $customer){
            $result[] = $customer->toArray();
        }
        $res->Json($result);
    }
    
    public function editCustomer(\Request $req, \Response $res) {
        $customer = new \Model\Customer($req->param("id"));
        $customer->first_name = $req->first_name;
        $customer->last_name = $req->last_name;
        $customer->email = $req->email;
        $customer->write();
        $res->Json($customer->toArray());
    }
    
    public function createCustomer(\Request $req, \Response $res) {
        $customer = new \Model\Customer();
        $customer->first_name = $req->first_name;
        $customer->last_name = $req->last_name;
        $customer->email = $req->email;
        $customer->write();
        $res->Json($customer->toArray());
    }
    
    public function deleteCustomer(\Request $req, \Response $res) {
        $customer = new \Model\Customer($req->param("id"));
        $customer->deleteFromDb();
        $res->Json(array("message" => "customer deleted"));
    }
}
