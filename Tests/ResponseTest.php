<?php
namespace TestNamespace;

use Output\View;

require_once(__DIR__ . "/../Classes/Response.php");
require_once(__DIR__ . "/../Classes/Output/View.php");
require_once(__DIR__ . "/../Classes/Router.php");

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testAddErrorMessage(){
        $view = new View([]);
        $response = new \Response($view);
        $response->addErrorMessage("test");

        $this->assertEquals(1, sizeof($_SESSION['errors']));
    }

    /**
     * @runInSeparateProcess
     */
    public function testRedirectTo(){
        $view = new View([]);
        $response = new \Response($view);
        $response->RedirectTo("Controller\Item::getItem", ["id" => 3]);
        $this->assertEquals(1, sizeof(header_list()));
    }


}