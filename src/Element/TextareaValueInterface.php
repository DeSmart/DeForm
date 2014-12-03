<?php

namespace DeForm\Element;

interface TextareaValueInterface
{

    /**
     * Get value from Textarea nodes.
     *
     * @return string|int
     */
    public function getValue();

    /**
     * Set value of Textarea.
     *
     * @param $value
     * @return self
     */
    public function setValue($value);

} 