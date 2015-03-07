<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model;

/**
 * Description of Abstract
 *
 * @author phil
 */
class AbModel {
    private $_idField, $_table, $_db;
    
    private $_fields;
    
    public function __construct($table, $idField, \Database $db, $id=null) {
        $this->_idField = $idField;
        $this->_table = $table;
        $this->_db = $db;
        $this->_fields = array();
        $this->defineFields();
        if(! is_null($id)){
            $this->loadFromDb($id);
        }
    }
    
    protected function defineFields(){
        $query = $this->_db->prepareQuery("DESC " . $this->_table);
        $query->execute();
        while($row = $query->fetch(\PDO::FETCH_ASSOC)){
            $this->_fields[$row['Field']] = $row['Default'];
        }
    }
    
    public function __get($name) {
        if(isset($this->_fields[$name])){
            return $this->_fields[$name];
        }
        return null;
    }
    
    public function __set($name, $value) {
        if(array_key_exists($name, $this->_fields)) {
            $this->_fields[$name] = $value;
        }
    }
    
    public function write(){
        if($this->_fields[$this->_idField]) {
            $this->update();
        } else {
            $this->insert();
        }
    }
    
    public function deleteFromDb(){
        $query = $this->_db->prepareQuery("DELETE FROM {$this->_table} WHERE {$this->_idField} = :id");
        $query->bindValue("id", $this->_fields[$this->_idField]);
        $query->execute();
    }
    
    protected function update(){
        $sql = "UPDATE {$this->_table} SET ";
        foreach($this->_fields as $name => $value) {
            if($name == $this->_idField){
                continue;
            }
            $updates[] = "{$name} = :{$name}";
        }
        $updates = implode(", ", $updates);
        $query = $this->_db->prepareQuery($sql . $updates . " WHERE {$this->_idField} = :id");
        foreach($this->_fields as $name => $value) {
            if($name == $this->_idField){
                continue;
            }
            $query->bindValue($name, $value);
        }
        $query->bindValue("id", $this->_fields[$this->_idField]);
        $query->execute();        
    }
    
    protected function insert(){
        $sql = "INSERT INTO {$this->_table} (::fields::) VALUES (::values::)";
        foreach($this->_fields as $name => $value) {
            if($name == $this->_idField){
                continue;
            }
            $fields[] = $name;
            $values[] = ":{$name}";
        }
        $fields = implode(", ", $fields);
        $values = implode(", ", $values);
        $sql = str_replace(array("::fields::", "::values::"), array($fields, $values), $sql);
        
        $query = $this->_db->prepareQuery($sql);
        foreach($this->_fields as $name => $value) {
            if($name == $this->_idField){
                continue;
            }
            $query->bindValue($name, $value);
        }
        $query->execute();
        $this->id = $this->_db->lastInsertId();
    }
    
    public function loadFromDb($id) {
        $query = $this->_db->prepareQuery("SELECT * FROM {$this->_table} WHERE {$this->_idField} = :id");
        $query->bindValue("id", $id, \PDO::PARAM_INT);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        $this->populateFromArray($row);
    }
    
    public function populateFromArray(Array $row){
        foreach($row as $field => $value){
            $this->_fields[$field] = $value;
        }
    }
    
    public function findByCriteria(array $criteria) {
        $sql = "SELECT * FROM {$this->_table} WHERE ";
        foreach($criteria as $field => $value) {
            $wheres[] = "{$field} = :{$field}";
        }
        $sql .= implode(" AND ", $wheres);
        $query = $this->_db->prepareQuery($sql);
        foreach($criteria as $field => $value) {
            $query->bindValue($field, $value);
        }
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if(! $row){
            throw new \RuntimeException("Criteria found no matches");
        }
        $this->populateFromArray($row);
    }
    
    public function fetchAll(array $criteria = array(), $limit = null, $offset = null){
        $wheres = "";
        if(sizeof($criteria)){
            foreach($criteria as $field => $value){
                $wheres[] = "{$field} = :{$field}";
            }
            $wheres = "WHERE " . implode(" AND ", $wheres);
        }
        
        
        if($offset && $limit) {
            $query = $this->_db->prepareQuery("SELECT * FROM {$this->_table} {$wheres} LIMIT:offset, :limit");
            $query->bindValue("offset", $offset, \PDO::PARAM_INT);
            $query->bindValue("limit", $limit, \PDO::PARAM_INT);
        } elseif($limit) {
            $query = $this->_db->prepareQuery("SELECT * FROM {$this->_table} {$wheres} LIMIT :limit");
            $query->bindValue("limit", $limit, \PDO::PARAM_INT);
        } else {
            $query = $this->_db->prepareQuery("SELECT * FROM {$this->_table} {$wheres}");
        }
        
        if(sizeof($criteria)){
            foreach($criteria as $field => $value){
                $query->bindValue($field, $value);
            }
        }
        
        $res = array();
        
        $query->execute();
        
        while($row = $query->fetch(\PDO::FETCH_ASSOC)){
            $model = new $this();
            $model->populateFromArray($row);
            $res[] = $model;
        }
        
        return $res;
    }
}
