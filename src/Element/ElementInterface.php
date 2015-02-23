<?php namespace DeForm\Element;

interface ElementInterface
{

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setValue($value);

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Return true if the element has an attribute "readonly" or "disabled".
     * If it does, it won't be parsed by DeForm.
     *
     * @return boolean
     */
    public function isReadonly();

    /**
     * Return the name of a form element.
     *
     * @return string
     */
    public function getName();

    /**
     * Mark element as valid.
     *
     * @return void
     */
    public function setValid();

    /**
     * Mark element as invalid.
     *
     * @param string $message
     * @return void
     */
    public function setInvalid($message);

    /**
     * Check if element is valid.
     *
     * @return boolean
     */
    public function isValid();

}
