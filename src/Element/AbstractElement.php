<?php namespace DeForm\Element;

abstract class AbstractElement implements ElementInterface
{

    /**
     * @var \DeForm\Node\NodeInterface
     */
    protected $node;

    /**
     * Return true if the element has an attribute "readonly" or "disabled".
     * If it does, it won't be parsed by DeForm.
     *
     * @return boolean
     */
    public function isReadonly()
    {
        if (true === $this->node->hasAttribute('readonly')) {
            return true;
        }

        if (true === $this->node->hasAttribute('disabled')) {
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
        return $this->node->getAttribute('name');
    }

    /**
     * Mark element as valid.
     *
     * @return void
     */
    public function setValid()
    {
        $this->node->removeAttribute('data-invalid');
    }

    /**
     * Mark element as invalid.
     *
     * @param string $message
     * @return void
     */
    public function setInvalid($message)
    {
        $this->node->setAttribute('data-invalid', $message);
    }

    /**
     * Check if element is valid.
     *
     * @return boolean
     */
    public function isValid()
    {
        return false === $this->node->hasAttribute('data-invalid');
    }

    /**
     * Return the validation rules for element.
     *
     * @return string|null
     */
    public function getValidationRules()
    {
        return $this->node->getAttribute('data-validate');
    }

} 
