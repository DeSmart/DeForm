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
    protected $elements = [];

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
        foreach ($this->elements as $item) {
            if (true === $item->hasAttribute('checked')) {
                $item->removeAttribute('checked');
            }

            if ($value === $item->getAttribute('value')) {
                $item->setAttribute('checked', 'checked');
            }
        }

        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return string|int
     */
    public function getValue()
    {
        foreach ($this->elements as $item) {
            if (true === $item->hasAttribute('checked')) {
                return $item->getAttribute('value');
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
            if (true === $item->hasAttribute('disabled')) {
                return true;
            }

            if (true === $item->hasAttribute('readonly')) {
                return true;
            }
        }

        return false;
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
        foreach ($this->elements as $item) {
            $item->removeAttribute('data-invalid');
        }
    }

    /**
     * Mark element as invalid
     *
     * @param string $message
     * @return void
     */
    public function setInvalid($message)
    {
        foreach ($this->elements as $item) {
            $item->setAttribute('data-invalid', $message);
        }
    }

    /**
     * Check if element is valid
     *
     * @return boolean
     */
    public function isValid()
    {
        foreach ($this->elements as $item) {
            if (true === $item->hasAttribute('data-invalid')) {
                return false;
            }
        }

        return true;
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

        if ($this->name !== $element->getAttribute('name')) {
            throw new \InvalidArgumentException('Attribute input[name] is invalid.');
        }

        $this->elements[] = $element;

        return $this;
    }

    /**
     * @return \DeForm\Node\NodeInterface[]
     */
    public function getElements()
    {
        return $this->elements;
    }
}
