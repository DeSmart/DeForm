<?php namespace DeForm\Element;

class CheckboxGroupElement extends AbstractGroup
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
        if (true === is_object($value)) {
            throw new \InvalidArgumentException('Invalid type of $value. Should be array.');
        }

        if (false === is_array($value)) {
            $value = (array)$value;
        }

        foreach ($this->elements as $item) {
            $new_value = in_array($item->getValue(), $value);

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
        $result = [];

        foreach ($this->elements as $element) {
            if (false === $element->isChecked()) {
                continue;
            }

            $result[] = $element->getValue();
        }

        return $result;
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
        if (false === $element instanceof CheckboxElement) {
            throw new \InvalidArgumentException('Only instance of CheckboxElement object can be added.');
        }

        $name = $element->getName();

        if ($this->countElements() > 0 && $name !== $this->getName()) {
            throw new \InvalidArgumentException('Attribute input[name] is invalid.');
        }

        $this->elements[] = $element;
        return $this;
    }

    /**
     * Return the name of a form element.
     *
     * @return string
     */
    public function getName()
    {
        $name = parent::getName();

        if ('[]' !== substr($name, -2)) {
            return $name;
        }

        $length = strlen($name);
        return substr($name, 0, $length - 2);
    }

}
