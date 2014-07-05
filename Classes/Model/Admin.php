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
class Admin extends AbModel{
    public function __construct($id = null) {
        parent::__construct("Admin", "id", \Registry::get("db"), $id);
    }
    
    public function checkUsername($username){
        try{
            $admin = new \Model\Admin();
            $admin->findByCriteria(array("username" => $username));
            if($admin->id != $this->id){
                return false;
            }
        } catch(\Exception $e) {
            //nothing
        }
        
        return true;
    }
}
