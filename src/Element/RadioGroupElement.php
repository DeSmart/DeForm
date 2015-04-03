<?php namespace DeForm\Element;

class RadioGroupElement extends AbstractGroup
{

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setValue($value)
    {
        if (false === is_string($value) && false === is_numeric($value)) {
            throw new \InvalidArgumentException('Invalid type of $value. Should be string or numeric.');
        }

        foreach ($this->elements as $item) {
            $new_value = ((string)$value === $item->getValue());

            $item->setValue($new_value);
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

}