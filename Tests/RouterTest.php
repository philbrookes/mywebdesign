<?php
namespace TestNamespace;

require_once(__DIR__ . "/../Classes/Router.php");

require_once(__DIR__ . "/../Classes/Config.php");

require_once(__DIR__ . "/../Classes/Request.php");

require_once(__DIR__ . "/../Classes/Model/AbModel.php");
require_once(__DIR__ . "/../Classes/Model/Admin.php");

require_once(__DIR__ . "/../Classes/Authentication/Auth.php");

require_once(__DIR__ . "/../Classes/Controller/AbController.php");
require_once(__DIR__ . "/../Classes/Controller/AbAuthController.php");
require_once(__DIR__ . "/../Classes/Controller/Item.php");
require_once(__DIR__ . "/../Classes/Controller/Home.php");
require_once(__DIR__ . "/../Classes/Controller/BadRequest.php");

if(! defined('APP_ROOT')) {
    define('APP_ROOT', __DIR__ . '/../');
}
class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRoute(){
        $_SERVER['REQUEST_METHOD'] = "GET";
        $_SERVER['REQUEST_URI'] = "/";
        $ret = \Router::route(new \Request(array()));
        $this->assertEquals([ new \Controller\Home(), "home"], $ret);
    }

    public function testPostRoute(){
        $_SERVER['REQUEST_METHOD'] = "POST";
        $_SERVER['REQUEST_URI'] = "/";
        $ret = \Router::route(new \Request(array()));
        $this->assertEquals([ new \Controller\Home(), "home"], $ret);
    }

    public function testAuthGetRoute(){
        $_SERVER['REQUEST_METHOD'] = "GET";
        $_SERVER['REQUEST_URI'] = "/item/3";
        $ret = \Router::route(new \Request(array()));
        $this->assertEquals([ new \Controller\Item(), "checkLogin"], $ret);
    }

    public function testAuthPostRoute(){
        $_SERVER['REQUEST_METHOD'] = "POST";
        $_SERVER['REQUEST_URI'] = "/item/3";
        $ret = \Router::route(new \Request(array()));
        $this->assertEquals([ new \Controller\Item(), "checkLogin"], $ret);
    }

    public function testGetControllerUrl(){
        $this->assertEquals(
            "/item/3",
            \Router::controllerUrl("Controller\Item::getItem", ["id" => 3])
        );
    }
}
