<?php

namespace SimpleDom\Tests;

class ElementTest extends \PHPUnit\Framework\TestCase
{
    /** @var \DOMDocument */
    private $domDocument;

    /** @var \SimpleDom\Document|\DOMDocument */
    private $simpleDomDocument;

    /** @var \SimpleDom\Element|\DOMElement */
    private $simpleDomElement;

    public function setUp()
    {
        parent::setUp();

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTML(
            "<div id='id' class='test class ahoy'>content</div><span id='span' class='class'>span</span>"
        );

        $this->simpleDomDocument = \SimpleDom\Document::fromDOMDocument($this->domDocument);

        $this->simpleDomElement  = $this->simpleDomDocument->getElementById("span");
    }

    public function testGetClassesReturnsTheCorrectClasses()
    {
        $elements = $this->simpleDomDocument->getElementsByClassName("test");
        $this->assertCount(1, $elements);
        $this->assertSame(
            ["test", "class", "ahoy"],
            $elements[0]->getClasses()
        );

        $elements = $this->simpleDomDocument->getElementsByClassName("class");
        $this->assertCount(2, $elements);
        $this->assertSame(
            ["test", "class", "ahoy"],
            $elements[0]->getClasses()
        );
        $this->assertSame(
            ["class"],
            $elements[1]->getClasses()
        );
    }

    public function testAddClassWorksProperly()
    {
        $this->assertSame(
            ["class"],
            $this->simpleDomElement->getClasses()
        );

        $this->simpleDomElement->addClasses(["first", "second", "third"]);

        $this->assertSame(
            ["class", "first", "second", "third"],
            $this->simpleDomElement->getClasses()
        );
    }

    public function testRemoveClassWorksProperly()
    {
        $this->simpleDomElement->addClasses(["first", "second", "third"]);
        $this->assertSame(
            ["class", "first", "second", "third"],
            $this->simpleDomElement->getClasses()
        );

        $this->simpleDomElement->removeClass("class");
        $this->assertSame(
            ["first", "second", "third"],
            $this->simpleDomElement->getClasses()
        );
    }

    public function testToggleClassWorksProperly()
    {
        $this->assertTrue($this->simpleDomElement->hasClass("class"));
        $this->assertFalse($this->simpleDomElement->hasClass("yoyo"));

        $this->simpleDomElement->toggleClass("yoyo");

        $this->assertTrue($this->simpleDomElement->hasClass("yoyo"));

        $this->simpleDomElement->toggleClass("yoyo");

        $this->assertFalse($this->simpleDomElement->hasClass("yoyo"));
    }

    public function testHasClass()
    {
        $this->assertTrue($this->simpleDomElement->hasClass("class"));
        $this->assertFalse($this->simpleDomElement->hasClass("yoyo"));

        $this->simpleDomElement->addClass("yoyo");

        $this->assertTrue($this->simpleDomElement->hasClass("yoyo"));
    }
}