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
    private static $_settings = [];
    
    public static function add($key, $value){
        if(! is_string($key)) {
            throw new InvalidArgumentException("Key must be a string.");
        }
        self::$_settings[$key] = $value;
    }
    
    public static function get($key){
        if(! array_key_exists($key, self::$_settings)) {
            throw new OutOfBoundsException("Key does not exist");
        }
        return self::$_settings[$key];
    }

    public static function reset(){
        self::$_settings = [];
    }
}
