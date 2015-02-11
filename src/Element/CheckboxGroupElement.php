<?php namespace DeForm\Element;

class CheckboxGroupElement extends AbstractGroup implements GroupInterface
{

    /**
     * @var \DeForm\Element\CheckboxElement[]
     */
    protected $elements = [];

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setValue($value)
    {
        // TODO: Implement setValue() method.
    }

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue()
    {
        // TODO: Implement getValue() method.
    }

    /**
     * Add new element to group.
     *
     * @param \DeForm\Element\ElementInterface $element
     * @return self
     * @throw \InvalidArgumentException
     */
    public function addElement(ElementInterface $element)
    {
        // TODO: Implement addElement() method.
    }

}
