<?php
namespace SimpleDom;

class NodeList extends \DOMNodeList
{
    /**
     * @var Element[]
     */
    private $elements = [];

    /**
     * @param Element $element
     *
     * @return $this
     */
    public function addElement(Element $element)
    {
        $this->elements[] = $element;
        return $this;
    }
}