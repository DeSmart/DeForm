<?php

namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class TextElement implements ElementInterface
{

    /**
     * @var \DeForm\Node\NodeInterface
     */
    protected $htmlNode;

    public function __construct(NodeInterface $htmlNode)
    {
        $this->htmlNode = $htmlNode;
    }

    /**
     * Set the value of a form element.
     *
     * @param string $value
     * @return self
     */
    public function setValue($value)
    {
        $this->htmlNode->setAttribute('value', $value);

        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return string|int
     */
    public function getValue()
    {
        return $this->htmlNode->getAttribute('value');
    }

    /**
     * Return true if the element has an attribute "readonly" or "disabled".
     * If it does, it won't be parsed by DeForm.
     *
     * @return boolean
     */
    public function isReadonly()
    {
        if (true === $this->htmlNode->hasAttribute('readonly')) {
            return true;
        }

        if (true === $this->htmlNode->hasAttribute('disabled')) {
            return true;
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
        return $this->htmlNode->getAttribute('name');
    }

    /**
     * Mark element as valid
     *
     * @return void
     */
    public function setValid()
    {
        $this->htmlNode->removeAttribute('data-invalid');
    }

    /**
     * Mark element as invalid
     *
     * @param string $message
     * @return void
     */
    public function setInvalid($message)
    {
        $this->htmlNode->setAttribute('data-invalid', $message);
    }

    /**
     * Check if element is valid
     *
     * @return boolean
     */
    public function isValid()
    {
        return false === $this->htmlNode->hasAttribute('data-invalid');
    }
}
