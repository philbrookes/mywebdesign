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
class InvoiceItem extends AbModel{
    public function __construct($id = null) {
        parent::__construct("InvoiceItem", "id", \Registry::get("db"), $id);
    }
}
