<?php
namespace Controller;

class Login {
    public function LoginForm() {
        $auth = new \Authentication\Login();
        $result = "";
        if(isset($_POST['username']) && isset($_POST['password'])){
            $result = $auth->Authenticate($_POST['username'], $_POST['password']);
        }
        if(! $auth->isLoggedIn()){
            $view = new \Output\View("main");
            $loginView = new \Output\View("login/login");
            $loginView->result = $result;
            $view->content = $loginView;
            return $view;
        } else {
            header("Location: /");
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: /");
    }
}