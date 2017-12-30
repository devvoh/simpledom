<?php
namespace SimpleDom;

class Element
{
    /** @var \DOMElement */
    private $domElement;

    /**
     * @param \DOMElement $domElement
     *
     * @return \DOMElement|Element
     */
    public static function fromDOMElement(\DOMElement $domElement)
    {
        $element = new static();
        $element->setDOMElement(clone $domElement);
        return $element;
    }

    /**
     * @param \DOMElement $domElement
     */
    public function setDOMElement(\DOMElement $domElement)
    {
        $this->domElement = $domElement;
    }

    /**
     * @return \DOMElement
     */
    public function getDOMElement()
    {
        return $this->domElement;
    }

    /**
     * @return string[]
     */
    public function getClasses()
    {
        $classes = $this->domElement->getAttribute("class");
        return explode(" ", $classes);
    }

    /**
     * @param string[] $classes
     *
     * @return Element
     */
    public function setClasses(array $classes)
    {
        $classesToSet = [];
        foreach ($classes as $class) {
            $classesToSet[$class] = $class;
        }
        $this->domElement->setAttribute("class", trim(implode(" ", $classesToSet)));
        return $this;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function hasClass($class)
    {
        return in_array($class, $this->getClasses());
    }

    /**
     * @param string[] $classes
     *
     * @return bool
     */
    public function hasClasses(array $classes)
    {
        $return = true;
        foreach ($classes as $class) {
            $return = $this->hasClass($class);
        }
        return $return;
    }

    /**
     * @param string $class
     *
     * @return Element
     */
    public function addClass($class)
    {
        $classes = $this->getClasses();
        $classes[] = $class;
        $this->setClasses($classes);
        return $this;
    }

    /**
     * @param string[] $classes
     *
     * @return Element
     */
    public function addClasses(array $classes)
    {
        foreach ($classes as $class) {
            $this->addClass($class);
        }
        return $this;
    }

    /**
     * @param string $class
     *
     * @return Element
     */
    public function removeClass($class)
    {
        $classes = $this->getClasses();
        foreach ($classes as $key => $value) {
            if ($class === $value) {
                unset($classes[$key]);
            }
        }
        $this->setClasses($classes);
        return $this;
    }

    /**
     * @param string[] $classes
     *
     * @return Element
     */
    public function removeClasses(array $classes)
    {
        foreach ($classes as $class) {
            $this->removeClass($class);
        }
        return $this;
    }

    /**
     * @param string $class
     *
     * @return Element
     */
    public function toggleClass($class)
    {
        if ($this->hasClass($class)) {
            $this->removeClass($class);
        } else {
            $this->addClass($class);
        }
        return $this;
    }

    /**
     * @param string[] $classes
     *
     * @return Element
     */
    public function toggleClasses(array $classes)
    {
        foreach ($classes as $class) {
            $this->toggleClass($class);
        }
        return $this;
    }

    /**
     * @return Element
     */
    public function clearClasses()
    {
        $this->domElement->setAttribute("class", "");
        return $this;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->domElement->{$name}(...$arguments);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->domElement->{$name};
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->domElement->{$name} = $value;
    }
}
