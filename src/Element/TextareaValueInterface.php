<?php namespace DeForm\Element;

interface TextareaValueInterface
{

    /**
     * Get value from Textarea nodes.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set value in node from Textarea.
     *
     * @param mixed $value
     * @return self
     */
    public function setValue($value);

} 