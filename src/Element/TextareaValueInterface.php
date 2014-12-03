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
     * Set value in node from Textarea.
     *
     * @param $value
     * @return self
     */
    public function setValue($value);

} 