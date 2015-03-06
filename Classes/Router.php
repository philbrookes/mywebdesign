<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 *
 * @author phil
 */
class Router {
    public static function route(\Request $request){
        $method = $request->getRequestMethod();
        $req = $request->getRequestedUri();

        $routes = new \Config("routes");
        $routes = $routes->$method;

        foreach($routes as $url => $handler){
            $url = preg_replace("|\:([a-z0-9\_\-]+)|iu", "(?P<$1>.*)", $url);
            if(preg_match("|{$url}|iu", $request->getRequestedUri(), $params)) {
                list($controller, $method) = explode("::", $handler);
                $request->setParams($params);
                break;
            }
        }
        if(!isset($controller))
        {
            $controller = "Controller\BadRequest";
            $method = "output404";
        }

        $controller = new $controller();
        return array($controller, $method);
    }
    
    public static function controllerUrl($controller, array $params = array()){
        $url = "";
        $routes = new \Config("routes");
        foreach((array)$routes->GET as $urlPattern => $handler) {
            if($controller == $handler) {
                $url = $urlPattern;
                break;
            }
        }
        if(!$url){
            foreach((array)$routes->POST as $urlPattern => $handler) {
                if($controller == $handler) {
                    $url = $urlPattern;
                    break;
                }
            }
        }
        
        foreach($params as $name => $value){
            $url = str_replace(":" . $name, $value, $url);
        }
        
        return $url;
    }
}
