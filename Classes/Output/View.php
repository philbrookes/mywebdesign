<?php

namespace Output;

class View {
    private $_file;
    private $_options;
    private $_path;
    private $_ext;
    public function __construct($viewFile, $options=array()) {
        $this->_path = APP_ROOT . "/view";
        $this->_ext = "view";
        $this->_file = $viewFile;
        $this->_options = $options;
    }
    
    public function __get($name) {
        if(isset($this->_options[$name])){
            return $this->_options[$name];
        }
        return null;
    }
    
    public function __set($name, $value) {
        $this->_options[$name] = $value;
    }
    
    public function render(){
        ob_start();
        include $this->_path . "/" . $this->_file . "." . $this->_ext;
        return ob_get_clean();
    }
    
    public function __toString() {
        return $this->render();
    }
}