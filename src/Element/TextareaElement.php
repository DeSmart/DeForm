<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class TextareaElement extends AbstractElement implements ElementInterface
{
    /**
     * @var \DeForm\Element\TextareaValueInterface
     */
    protected $textValue;

    public function __construct(NodeInterface $node, TextareaValueInterface $textValue)
    {
        $this->node = $node;
        $this->textValue = $textValue;
    }

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setValue($value)
    {
        $this->textValue->setValue($value);

        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->textValue->getValue();
    }

}
