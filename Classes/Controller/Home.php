<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

/**
 * Description of Home
 *
 * @author phil
 */
class Home extends AbAuthController{
    public function home(\Request $req, \Response $res) {
        $view = new \Output\View("home/menu");
        $res->addView("content", $view);
    }
}
