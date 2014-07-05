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
class Customer extends AbModel{
    public function __construct($id = null) {
        parent::__construct("Customer", "id", \Registry::get("db"), $id);
    }
    
    public function getItems(){
        $item = new \Model\Item();
        return $item->fetchAll(array("customer_id" => $this->id));
    }
    
    public function getExpiringItems(){
        $res = array();
        foreach($this->getItems as $item){
            if(strtotime($item->next_bill_date) < mktime() + (86400 * 30))
            {
                
            }
        }
    }
    
    public function getUnpaidInvoices(){
        $item = new \Model\Invoice();
        return $item->fetchAll(array("customer_id" => $this->id, "status" => "unpaid"));
    }
    
    public function getPaidInvoices(){
        $item = new \Model\Invoice();
        return $item->fetchAll(array("customer_id" => $this->id, "status" => "paid"));
    }
    
    public function getInvoices(){
        $item = new \Model\Invoice();
        return $item->fetchAll(array("customer_id" => $this->id));
    }
    
    public function getFullName() {
        return $this->first_name . " " . $this->last_name;
    }
}
