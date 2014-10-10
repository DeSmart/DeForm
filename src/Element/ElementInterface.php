<?php namespace DeForm\Element;

interface ElementInterface 
{

    /**
     * Set value in a form element.
     *
     * @param string $value
     * @return self
     */
    public function setValue($value);

    /**
     * Check element if has an attribute "readonly" or "disabled".
     * Readonly element won't be parsed by DeForm.
     *
     * @return boolean
     */
    public function isReadonly();

}
