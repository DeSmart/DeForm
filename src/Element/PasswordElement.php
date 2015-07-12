<?php namespace DeForm\Element;

class PasswordElement extends TextElement
{
    /**
     * Value of element.
     *
     * @var string
     */
    protected $value;

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setValue($value)
    {
        if (false === is_string($value) && false === is_numeric($value)) {
            throw new \InvalidArgumentException('Invalid type of $value. Should be string or numeric.');
        }

        $this->value = $value;
        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
