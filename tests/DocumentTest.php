<?php

namespace SimpleDom\Tests;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    /** @var \DOMDocument */
    private $domDocument;

    /** @var \SimpleDom\Document|\DOMDocument */
    private $simpleDomDocument;

    public function setUp()
    {
        parent::setUp();

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTML(
            "<div id='id' class='test class ahoy'>content</div><span class='class'>span</span>"
        );

        $this->simpleDomDocument = \SimpleDom\Document::fromDOMDocument($this->domDocument);
    }

    public function testCreateFromDOMDocumentReturnsSimpleDomDocumentAndPassesThroughCalls()
    {
        $this->assertSame(
            $this->domDocument->saveHTML(),
            $this->simpleDomDocument->saveHTML()
        );
    }

    public function testGetByTagNameReturnsSimpleDomElements()
    {
        $elements = $this->simpleDomDocument->getElementsByTagName("div");

        $this->assertCount(1, $elements);
        $this->assertInstanceOf(\SimpleDom\Element::class, $elements[0]);
        $this->assertSame("content", $elements[0]->textContent);
    }

    public function testGetByIdReturnsSimpleDomElements()
    {
        $element = $this->simpleDomDocument->getElementById("id");
        $this->assertInstanceOf(\SimpleDom\Element::class, $element);
        $this->assertSame("content", $element->textContent);
    }

    public function testGetByClassIsSpecificEnough()
    {
        $elements = $this->simpleDomDocument->getElementsByClassName("ahoy");
        $this->assertCount(1, $elements);

        $elements = $this->simpleDomDocument->getElementsByClassName("class");
        $this->assertCount(2, $elements);
    }

    public function testGetByClassNamesReturnsOnlyThoseWithAll()
    {
        $elements = $this->simpleDomDocument->getElementsByClassNames(["ahoy", ""]);
        $this->assertCount(1, $elements);
        $this->assertTrue($elements[0]->hasClasses(["class", "ahoy"]));
    }

    public function testCreateElementReturnsSimpleDomElement()
    {
        $element = $this->simpleDomDocument->createElement("a", "stuff");
        $this->assertInstanceOf(\SimpleDom\Element::class, $element);

        $this->assertSame("a", $element->tagName);
        $this->assertSame("stuff", $element->textContent);
    }
}