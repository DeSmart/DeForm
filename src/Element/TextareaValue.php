<?php

namespace DeForm\Element;

class TextareaValue implements TextareaValueInterface
{

    /**
     * @var \DOMText
     */
    protected $text;

    public function __construct(\DOMText $text)
    {
        $this->text = $text;
    }

    /**
     * Get value from Textarea nodes.
     *
     * @return string|int
     */
    public function getValue()
    {
        return $this->text->nodeValue;
    }

    /**
     * Set value in node from Textarea.
     *
     * @param $value
     * @return self
     */
    public function setValue($value)
    {
        $this->text = new \DOMText($value);

        return $this;
    }

}
