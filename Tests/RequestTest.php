<?php
namespace TestNamespace;

require_once(__DIR__ . "/../Classes/Registry.php");

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testParams(){
        $request = new \Request([]);
        $request->setParams(["id" => 1]);
        $this->assertEquals(1, $request->param("id"));
    }

    public function testMagicGet(){
        $request = new \Request(["name" => "test_name"]);
        $this->assertEquals("test_name", $request->name);
    }

    public function testPopErrors(){
        $_SESSION['errors'] = ["error #1"];
        $request = new \Request([]);
        $this->assertEquals(["error #1"], $request->popErrorMessages());
        $this->assertEquals(0, sizeof($_SESSION['errors']));
    }

    public function testGetRequestedURI(){
        $_SERVER['REQUEST_URI'] = "test";
        $request = new \Request([]);
        $this->assertEquals("test", $request->getRequestedUri());
    }

    public function testGetRequestMethod(){
        $_SERVER['REQUEST_METHOD'] = "test";
        $request = new \Request([]);
        $this->assertEquals("test", $request->getRequestMethod());
    }
}