<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model;

/**
 * Description of Admin
 *
 * @author phil
 */
class Invoice extends AbModel{
    public function __construct($id = null) {
        parent::__construct("Invoice", "id", \Registry::get("db"), $id);
    }
    
    public function getCustomer() {
        return new \Model\Customer($this->customer_id);
    }
    
    public function getItems() {
        $item = new \Model\InvoiceItem();
        return $item->fetchAll(array("invoice_id" => $this->id));
    }
            
    
    public function getTotal(){
        $total = 0;
        foreach($this->getItems() as $item) {
            $total += $item->amount;
        }
        return $total;
    }
    
    public function getIssueDate($format){
        return date($format, strtotime($this->issue_date));
    }
    
    public function getDueDate($format){
        return date($format, strtotime($this->due_date));
    }
    
    public function getPaidDate($format){
        if($this->paid_date == "0000-00-00 00:00:00"){
            return "n/a";
        }
        return date($format, strtotime($this->paid_date));
    }
    
    public function getOutputId(){
        if($this->id <= 100){
            return $this->id + 100;
        }
        return $this->id;
    }
}
