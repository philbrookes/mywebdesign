<?php

namespace Authentication;

class Auth {
    public function isLoggedIn(){
        return (bool) isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0;
    }
    
    public function Authenticate($username, $password){
        try{
            $db = \Registry::get("db");
            $admin = new \Model\Admin();
            $admin->findByCriteria(
                array("username" => $username)
            );
            if($admin->id && crypt($password, $admin->password) == $admin->password){
                $_SESSION['admin_id'] = $admin->id;
                return $admin;
            }
        }catch(\RuntimeException $ex){
            return false;
        }
        return false;
    }
    
    public function Logout(){
        session_destroy();
    }
    
}
