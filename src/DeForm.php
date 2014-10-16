<?php namespace DeForm;

class DeForm
{
    protected $request;

    public function __construct(\DeForm\Request\RequestInterface $request)
    {
        $this->request = $request;
    }

    public function isSubmitted()
    {
        return $this->request;
    }

}
