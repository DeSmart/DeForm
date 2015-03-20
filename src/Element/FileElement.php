<?php

namespace DeForm\Element;

use DeForm\Node\NodeInterface;
use DeForm\Request\RequestInterface;

class FileElement extends AbstractElement
{
    /**
     * @var \DeForm\Request\RequestInterface
     */
    protected $request;

    public function __construct(NodeInterface $node, RequestInterface $request)
    {
        $this->node = $node;
        $this->request = $request;
    }

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \BadMethodCallException
     */
    public function setValue($value)
    {
        throw new \BadMethodCallException('Cannot change value of input[type=file] element.');
    }

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->request->file($this->getName());
    }

}
