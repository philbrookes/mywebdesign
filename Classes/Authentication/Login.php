<?php

namespace Authentication;

class Login {
    public function isLoggedIn(){
        return (bool) isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0;
    }
    
    public function Authenticate($username, $password){
        $db = \Registry::get("db");
        $admin = new \Model\Admin();
        $admin->findByCriteria(
            array("username" => $username, "password" => md5($password))
        );
        if($admin->id)
        {
            $_SESSION['admin_id'] = $admin->id;
            return true;
        }
        return "bad login data";
    }
    
}
