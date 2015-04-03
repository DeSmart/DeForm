<?php namespace DeForm\Validation;

interface ValidatorInterface
{

    /**
     * @param array $values
     * @return boolean
     */
    public function validate(array $values);

    /**
     * Return an array with validation messages.
     *
     * @return array
     */
    public function getMessages();
}
