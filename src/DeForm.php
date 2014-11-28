<?php namespace DeForm;

use DeForm\Node\NodeInterface;
use DeForm\Request\RequestInterface;

class DeForm
{
    
    /**
     * @var \DeForm\Request\RequestInterface
     */
    protected $request;
    
    /**
     * @var \DeForm\Node\NodeInterface
     */
    protected $formNode;
    
    /**
     * @var \DeForm\Element\ElementInterface[]
     */
    protected $elements = [];
    
    const DEFORM_ID = '__deform_id';

    public function __construct(NodeInterface $formNode, RequestInterface $request)
    {
        $this->formNode = $formNode;
        $this->request = $request;
    }

    /**
     * Returns true if the form was submitted, false otherwise.
     * 
     * @return boolean
     */
    public function isSubmitted()
    {
        if ($this->formNode->getAttribute('name') === $this->request->get(static::DEFORM_ID)) {
          return true;
        }

        return false;
    }

    /**
     * Registers a new form element.
     * 
     * @param \DeForm\Element\ElementInterface $element
     * @return self
     */
    public function addElement($element)
    {
        $name = $element->getName();
        
        if (true === array_key_exists($name, $this->elements)) {
            throw new \LogicException(sprintf('Cannot set the element "%s" more than once (same name)', $name));
        }
        
        $request_value = $this->request->get($name);
        
        if (true === $this->isSubmitted() && null !== $request_value && false === $element->isReadonly()) {
            $element->setValue($request_value);
        }
        
        $this->elements[$name] = $element;
        
        return $this;
    }

    /**
     * Returns a form element by its name.
     * 
     * @param string $name
     * @return \DeForm\Element\ElementInterface
     * @throws \LogicException
     */
    public function getElement($name)
    {
        if (false === array_key_exists($name, $this->elements)) {
            throw new \LogicException(sprintf('Trying to get a non-existing element ("%s")', $name));
        }
        
        return $this->elements[$name];
    }
}
