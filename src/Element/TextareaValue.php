<?php namespace DeForm\Element;

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
     * @return string
     */
    public function getValue()
    {
        return $this->text->nodeValue;
    }

    /**
     * Set value in node from Textarea.
     *
     * @param string|int|float $value
     * @return mixed
     */
    public function setValue($value)
    {
        if (false === is_string($value) && false === is_numeric($value)) {
            throw new \InvalidArgumentException('Invalid type of $value. Should be string or numeric.');
        }

        $this->text = new \DOMText($value);
        return $this;
    }

}
