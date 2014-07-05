<?php
namespace Controller;

class Login {
    public function logout(\Request $req, \Response $res) {
        $auth = new \Authentication\Auth();
        $auth->Logout();
        $res->Json(array("flash" => "logged out successfully"));
    }
    
    public function login(\Request $req, \Response $res) {
        $auth = new \Authentication\Auth();

        $admin = $auth->Authenticate($req->username, $req->password);
        if($admin){
            $res->Json(array("flash" => "login successful"));
            return;
        }
        $res->Json(array("flash" => "bad username or password"), "401");
    }
    
    public function isLoggedIn(\Request $req, \Response $res){
        if($_SESSION['admin_id']){
            $res->Json(array("flash" => "logged in"));
        } else {
            $res->Json(array("flash" => "not logged in"), "401");
        }
    }
}