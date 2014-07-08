<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Controller;
/**
 * Description of Product
 *
 * @author phil
 */
class Product extends AbAuthController{
    public function getProducts(\Request $req, \Response $res){
        $product = new \Model\Product();
        $products = $product->fetchAll();
        
        $result = Array();
        foreach($products as $product){
            $result[] = $product->toArray();
        }
        $res->Json($result);
    }
    
    public function editForm(\Request $req, \Response $res) {
        $product = new \Model\Product($req->param("id"));
        $view = new \Output\View("product/edit");
        $view->formHandler = "Controller\Product::editProduct";
        $view->product = $product;
        $view->title = "Edit Product";
        $res->addView("content", $view);
    }
    
    public function editProduct(\Request $req, \Response $res) {
        $product = new \Model\Product($req->param("id"));
        $product = $this->_populateProductFromRequest($product, $req, "Controller\\Product::editForm");
        $product->write();
        header("location: " . \Router::controllerUrl("Controller\Product::listProduct"));
    }
    
    public function createForm(\Request $req, \Response $res) {
        $product = new \Model\Product();
        $view = new \Output\View("product/edit");
        $view->formHandler = "Controller\Product::createProduct";
        $view->product = $product;
        $view->title = "Create Product";
        $res->addView("content", $view);
    }
    
    public function createProduct(\Request $req, \Response $res) {
        $product = new \Model\Product();
        $product = $this->_populateProductFromRequest($product, $req, "Controller\\Product::createForm");
        $product->write();
        \Response::RedirectTo("Controller\Product::listProduct", array(), "Product created");
    }
    
    public function deleteProduct(\Request $req, \Response $res) {
        $product = new \Model\Product($req->param("id"));
        $product->deleteFromDb();
        \Response::RedirectTo("Controller\Product::listProduct", array(), "Product '{$product->username}' deleted");
    }
    
    private function _populateProductFromRequest(\Model\Product $product, \Request $req, $handler) {
        $product->name = $req->name;
        $product->price = $req->price;
        $product->cost = $req->cost;
        $product->repeating = $req->repeating;
        return $product;
    }   
}
