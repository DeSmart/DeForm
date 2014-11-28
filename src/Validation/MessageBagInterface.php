<?php namespace DeForm\Validation;

interface MessageBagInterface 
{

    /**
     * Return all messages for given element
     *
     * @param string $name
     * @return array
     */
    public function get($name);

}
