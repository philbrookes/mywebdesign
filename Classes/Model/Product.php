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
class Product extends AbModel{
    public function __construct($id = null) {
        parent::__construct("Product", "id", \Registry::get("db"), $id);
    }
    
    public function outputRepeating($i=null) {
        if(is_null($i)){
            $i = $this->repeating;
        }
        if($i == 0) {
            return "Never";
        }
        if($i == 1) {
            return "Every month";
        }
        if($i == 12) {
            return "Every year";
        }
        else return "Every {$i} months";
    }
}
