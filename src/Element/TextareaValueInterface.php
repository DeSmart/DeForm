<?php namespace DeForm\Element;

interface TextareaValueInterface
{

    /**
     * Get value from Textarea nodes.
     *
     * @return string
     */
    public function getValue();

    /**
     * Set value in node from Textarea.
     *
     * @param string|int|float $value
     * @return self
     */
    public function setValue($value);

} 