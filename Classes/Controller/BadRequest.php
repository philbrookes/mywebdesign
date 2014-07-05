<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

/**
 * Description of BadRequest
 *
 * @author phil
 */
class BadRequest {
    public function output404(\Request $req, \Response $res){
        $view = new \Output\View("404");
        $view->request = $req->getRequestedUri();
        $view->method = $req->getRequestMethod();
        $res->addView("content", $view);
    }
}
