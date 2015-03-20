<?php namespace DeForm\Validation;

interface ValidatorInterface
{

    /**
     * Return true if the data passes the validation rules. Otherwise returns false.
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
     * Get validation messages.
     *
     * @return MessageBagInterface
     */
    public function getMessages();

}
