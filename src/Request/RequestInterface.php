<?php namespace DeForm\Request;

interface RequestInterface
{

    public function get($value);

    public function file($name);
    
}
