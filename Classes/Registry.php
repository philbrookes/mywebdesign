<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registry
 *
 * @author phil
 */
class Registry {
    private static $_settings;
    
    public static function add($key, $value){
        self::$_settings[$key] = $value;
    }
    
    public static function get($key){
        return self::$_settings[$key];
    }
}
