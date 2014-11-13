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

}
