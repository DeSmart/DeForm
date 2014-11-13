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
    protected $elements = array();
    
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

    public function setElementsValues($data)
    {
        foreach ($data as $fieldName => $value) {
            $this->getElement($fieldName)->setValue($value);
        }
    }

    /**
     * @todo Write desc.
     * 
     * @param \DeForm\Element\ElementInterface $element
     */
    public function setElement($element)
    {
        $name = $element->getName();
        
        if (true === key_exists($name, $this->elements)) {
            throw new \LogicException(sprintf('Cannot set the element "%s" more than once (same name)', $name));
        }
        
        $this->elements[$element->getName()] = $element;
    }

    /**
     * @todo Write desc.
     * 
     * @param string $name
     * @return \DeForm\Element\ElementInterface
     * @throws \LogicException
     */
    public function getElement($name)
    {
        if (false === key_exists($name, $this->elements)) {
            throw new \LogicException(sprintf('Trying to get a non-existing element ("%s")', $name));
        }
        
        return $this->elements[$name];
    }
}
