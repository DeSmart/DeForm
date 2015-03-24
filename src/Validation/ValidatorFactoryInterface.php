<?php namespace DeForm\Validation;

interface ValidatorFactoryInterface
{

    /**
     * @param array $values
     * @param array $rules
     * @return \DeForm\Validation\ValidatorInterface
     */
    public function make(array $values, array $rules);
}