<?php namespace DeForm\Validation;

interface ValidatorFactoryInterface
{

    /**
     * @param array $rules
     * @return \DeForm\Validation\ValidatorInterface
     */
    public function make(array $rules);
}