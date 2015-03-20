<?php namespace DeForm\Validation;

interface MessageBagInterface
{

    /**
     * Return first message for given element.
     *
     * @param string|null $name
     * @return array
     */
    public function first($name);

}
