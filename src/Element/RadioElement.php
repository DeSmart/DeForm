<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class RadioElement implements GroupInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \DeForm\Node\NodeInterface[]
     */
    protected $elements;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Set the value of a form element.
     *
     * @param string $value
     * @return self
     */
    public function setValue($value)
    {
        // TODO: Implement setValue() method.
    }

    /**
     * Get the value of a form element.
     *
     * @return string|int
     */
    public function getValue()
    {
        // TODO: Implement getValue() method.
    }

    /**
     * Return true if the element has an attribute "readonly" or "disabled".
     * If it does, it won't be parsed by DeForm.
     *
     * @return boolean
     */
    public function isReadonly()
    {
        // TODO: Implement isReadonly() method.
    }

    /**
     * Return the name of a form element.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Mark element as valid
     *
     * @return void
     */
    public function setValid()
    {
        // TODO: Implement setValid() method.
    }

    /**
     * Mark element as invalid
     *
     * @param string $message
     * @return void
     */
    public function setInvalid($message)
    {
        // TODO: Implement setInvalid() method.
    }

    /**
     * Check if element is valid
     *
     * @return boolean
     */
    public function isValid()
    {
        // TODO: Implement isValid() method.
    }

    /**
     * @param \DeForm\Node\NodeInterface $element
     * @return self
     * @throw \InvalidArgumentException
     */
    public function addElement(NodeInterface $element)
    {
        if ('input_radio' !== $element->getElementType()) {
            throw new \InvalidArgumentException('Group accepts only input[type="radio"] elements.');
        }

        $this->elements[] = $element;

        return $this;
    }

}
