<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Controller;
/**
 * Description of Invoice
 *
 * @author phil
 */
class Invoice extends AbAuthController{
    public function viewInvoice(\Request $req, \Response $res){
        
    }
    
    public function invoicePaid(\Request $req, \Response $res){
        $invoice = new \Model\Invoice($req->param("invoice_id"));
        $invoice->paid_date = date("Y-m-d");
        $invoice->status = "paid";
        $invoice->write();
        $res->RedirectTo("Controller\Customer::viewCustomer", array("id" => $req->param("customer_id")));
    }
    
    public function invoiceUnpaid(\Request $req, \Response $res){
        $invoice = new \Model\Invoice($req->param("invoice_id"));
        $invoice->paid_date = "0000-00-00";
        $invoice->status = "unpaid";
        $invoice->write();
        $res->RedirectTo("Controller\Customer::viewCustomer", array("id" => $req->param("customer_id")));
    }
}
