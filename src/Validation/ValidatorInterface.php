<?php namespace DeForm\Validation;

interface ValidatorInterface
{

    /**
     * @param array $values
     * @return boolean
     */
    public function validate(array $values);

    /**
     * Get validation messages.
     *
     * @return MessageBagInterface
     */
    public function getMessages();

}
