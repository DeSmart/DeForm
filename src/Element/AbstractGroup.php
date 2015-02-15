<?php namespace DeForm\Element;

abstract class AbstractGroup
{

    /**
     * Return true if the element has an attribute "readonly" or "disabled".
     * If it does, it won't be parsed by DeForm.
     *
     * @return boolean
     */
    public function isReadonly()
    {
        foreach ($this->elements as $item) {
            if (true === $item->isReadonly()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return the name of a form element.
     *
     * @return string
     * @throw \UnexpectedValueException
     */
    public function getName()
    {
        if (0 === $this->countElements()) {
            throw new \UnexpectedValueException('Group of elements is empty.');
        }

        return $this->elements[0]->getName();
    }

    /**
     * Mark element as valid.
     *
     * @return void
     */
    public function setValid()
    {
        foreach ($this->elements as $item) {
            $item->setValid();
        }
    }

    /**
     * Mark element as invalid.
     *
     * @param string $message
     * @return void
     */
    public function setInvalid($message)
    {
        foreach ($this->elements as $item) {
            $item->setInvalid($message);
        }
    }

    /**
     * Check if element is valid.
     *
     * @return boolean
     */
    public function isValid()
    {
        foreach ($this->elements as $item) {
            if (false === $item->isValid()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return all elements from group.
     *
     * @return \DeForm\Element\ElementInterface[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Return number of elements in group.
     *
     * @return int
     */
    public function countElements()
    {
        return count($this->elements);
    }

    /**
     * Return a single element of group based on value name.
     *
     * @param string $value
     * @return \DeForm\Element\ElementInterface
     * @throw \InvalidArgumentException
     */
    public function getElement($value)
    {
        foreach ($this->elements as $item) {
            if ($value === $item->getValue()) {
                return $item;
            }
        }

        throw new \InvalidArgumentException(sprintf('Cannot find element with value %s', $value));
    }

}