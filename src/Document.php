<?php
namespace SimpleDom;

class Document
{
    /**
     * @var \DOMDocument
     */
    private $domDocument;

    /**
     * @param \DOMDocument $domDocument
     *
     * @return Document|\DOMDocument
     */
    public static function fromDOMDocument(\DOMDocument $domDocument)
    {
        $document = new static();
        $document->setDOMDocument(clone $domDocument);
        return $document;
    }

    /**
     * @param \DOMDocument $domDocument
     */
    public function setDOMDocument(\DOMDocument $domDocument)
    {
        $this->domDocument = $domDocument;
    }

    /**
     * @param string $name
     *
     * @return NodeList
     */
    public function getElementsByTagName($name)
    {
        $elements = $this->domDocument->getElementsByTagName($name);
        return $this->convertElementsToSimpleDomElements($elements);
    }

    /**
     * @param string $name
     *
     * @return NodeList
     */
    public function getElementsByClassName($name)
    {
        return $this->getElementsByClassNames([$name]);
    }

    /**
     * @param string[] $names
     *
     * @return NodeList
     */
    public function getElementsByClassNames(array $names)
    {
        $parts = [];
        foreach ($names as $name) {
            $parts[] = "contains(@class, '{$name}')";
        }
        $query = "//*[" . implode(" and ", $parts) . "]";

        $finder   = new \DOMXPath($this->domDocument);
        $elements = $finder->query($query);
        return $this->convertElementsToSimpleDomElements($elements);
    }

    /**
     * @param string $elementId
     *
     * @return \DOMElement|Element
     */
    public function getElementById($elementId)
    {
        $element =$this->domDocument->getElementById($elementId);
        return Element::fromDOMElement($element);
    }

    /**
     * @param string      $name
     * @param string|null $value
     *
     * @return \DOMElement|Element
     */
    public function createElement ($name, $value = null)
    {
        $element = $this->domDocument->createElement($name, $value);
        return Element::fromDOMElement($element);
    }

    /**
     * @param \DOMElement[]|\DOMNodeList $elements
     *
     * @return NodeList
     */
    private function convertElementsToSimpleDomElements($elements)
    {
        $nodeList = new NodeList();

        foreach ($elements as $element) {
            $nodeList->addElement(Element::fromDOMElement($element));
        }

        return $nodeList;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->domDocument->{$name}(...$arguments);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->domDocument->{$name};
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->domDocument->{$name} = $value;
    }
}