<?php

class Config {
    private $_vars;
    private $_confDir = "/config/";
    private $_confExt = "ini";
    
    public function __construct($iniFile){
        $iniFile = APP_ROOT . $this->_confDir . $iniFile . "." . $this->_confExt;
        $this->_vars = parse_ini_file($iniFile, true);
    }
    
    public function __get($name) {
        if(isset($this->_vars[$name]) && !is_array($this->_vars[$name])){
            return $this->_vars[$name];
        }else if(is_array($this->_vars[$name])){
            return (object) $this->_vars[$name];
        }
    }
}