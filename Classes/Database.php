<?php

class Database {
    private $_conn;
    
    public function __construct($config) {
        $this->_conn = $this->connect($config);
    }
    
    private function connect($config){
        $dsn = "mysql:host={$config->hostname};dbname={$config->database}";
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        return new PDO($dsn, $config->username, $config->password, $options);
    }
    
    public function prepareQuery($sql){
        return $this->_conn->prepare($sql);
    }
    
    public function lastInsertId(){
        return $this->_conn->lastInsertId();
    }
}