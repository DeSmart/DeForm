<?php namespace DeForm\Element;

class RadioGroupElement implements GroupInterface {

    /**
     * @var \DeForm\Element\RadioElement[]
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
        foreach ($this->elements as $item) {
            if (true === $item->isChecked()) {
                $item->setUnchecked();
            }

            if ($value === $item->getValue()) {
                $item->setChecked();
            }
        }

        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue()
    {
        foreach ($this->elements as $item) {
            if (true === $item->isChecked()) {
                return $item->getValue();
            }
        }

        return null;
    }

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
            throw new \UnexpectedValueException('Radio Elements Group is empty.');
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
     * Add new element to group.
     *
     * @param \DeForm\Element\ElementInterface $element
     * @return self
     * @throw \InvalidArgumentException
     */
    public function addElement(ElementInterface $element)
    {
        if (false === $element instanceof RadioElement) {
            throw new \InvalidArgumentException('Only instance of RadioElement object can be added.');
        }

        if ($this->countElements() > 0 && $element->getName() !== $this->getName()) {
            throw new \InvalidArgumentException('Attribute input[name] is invalid.');
        }

        $this->elements[] = $element;
        return $this;
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