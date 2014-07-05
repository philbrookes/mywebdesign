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
class Item extends AbModel{
    public function __construct($id = null) {
        parent::__construct("Item", "id", \Registry::get("db"), $id);
    }

    public function getProduct(){
        return new \Model\Product($this->product_id);
    }
    
    public function getCustomer(){
        return new \Model\Customer($this->customer_id);
    }
    
    public function getBillDate($format){
        return date($format, strtotime($this->next_bill_date));
    }
    
    public function getAllProducts(){
        $product = new \Model\Product();
        return $product->fetchAll();
    }
}
