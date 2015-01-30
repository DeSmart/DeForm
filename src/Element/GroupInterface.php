<?php namespace DeForm\Element;

interface GroupInterface extends ElementInterface
{

    /**
     * Add new element to group.
     *
     * @param \DeForm\Element\ElementInterface $element
     * @return self
     * @throw \InvalidArgumentException
     */
    public function addElement(ElementInterface $element);

    /**
     * Return all elements from group.
     *
     * @return \DeForm\Element\ElementInterface[]
     */
    public function getElements();

    /**
     * Return a single element of group based on value name.
     *
     * @param string $value
     * @return \DeForm\Element\ElementInterface
     * @throw \InvalidArgumentException
     */
    public function getElement($value);

}