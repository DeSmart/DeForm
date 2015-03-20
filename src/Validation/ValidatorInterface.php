<?php namespace DeForm\Validation;

interface ValidatorInterface
{

    /**
     * Add validation
     *
     * @param string $name
     * @param string $rules
     * @param mixed $value
     */
    public function addValidation($name, $rules, $value);

    /**
     * @return boolean
     */
    public function validate();

    /**
     * Get validation messages
     *
     * @return MessageBagInterface
     */
    public function getMessages();

}
