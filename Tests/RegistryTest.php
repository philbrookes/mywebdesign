<?php
namespace TestNamespace;

require_once(__DIR__ . "/../Classes/Registry.php");

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \OutOfBoundsException
     */
    public function testReset(){
        \Registry::add("test", "test");
        $this->assertEquals("test", \Registry::get("test"));
        \Registry::reset();
        $this->assertEquals("test", \Registry::get("test"));
    }
    public function testSetAndGetString()
    {
        \Registry::add("test-key", "test-value");
        $this->assertEquals("test-value", \Registry::get("test-key"));
    }

    public function testSetAndGetInt()
    {
        \Registry::add("test-key", 123);
        $this->assertEquals(123, \Registry::get("test-key"));
    }

    public function testSetAndGetArr()
    {
        \Registry::add("test-key", array(1, 2, "three"));
        $this->assertEquals(array(1, 2, "three"), \Registry::get("test-key"));

        \Registry::add("test-key", array(1, array("one", 2), "three"));
        $this->assertEquals(array(1, array("one", 2), "three"), \Registry::get("test-key"));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadSetArrKey()
    {
        \Registry::add(array(), "test-value");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadSetIntKey()
    {
        \Registry::add(1, "test-value");
    }
}