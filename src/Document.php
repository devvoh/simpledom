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
        $document->setDOMDocument($domDocument);
        return $document;
    }

    /**
     * @param \DOMDocument $domDocument
     *
     * @return Document
     */
    public function setDOMDocument(\DOMDocument $domDocument)
    {
        $this->domDocument = $domDocument;
        return $this;
    }

    /**
     * @return \DOMDocument
     */
    public function getDOMDocument()
    {
        return $this->domDocument;
    }

    /**
     * @param string $name
     *
     * @return \DOMElement[]|Element[]
     */
    public function getElementsByTagName($name)
    {
        $elements = $this->domDocument->getElementsByTagName($name);
        return $this->convertElementsToSimpleDomElements($elements);
    }

    /**
     * @param string $name
     *
     * @return \DOMElement[]|Element[]
     */
    public function getElementsByClassName($name)
    {
        return $this->getElementsByClassNames([$name]);
    }

    /**
     * @param string[] $names
     *
     * @return \DOMElement[]|Element[]
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
     * @return \DOMElement[]|Element[]
     */
    private function convertElementsToSimpleDomElements($elements)
    {
        $customElements = [];
        foreach ($elements as $element) {
            $customElements[] = Element::fromDOMElement($element);
        }
        return $customElements;
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