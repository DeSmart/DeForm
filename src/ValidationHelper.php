<?php namespace DeForm;

use DeForm\Validation\ValidatorFactoryInterface;

class ValidationHelper
{

    /**
     * @var ValidatorFactoryInterface
     */
    protected $factory;

    public function __construct(ValidatorFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param array $rules
     * @param array $values
     * @returns bool
     */
    public function validate(array $rules, array $values)
    {
    }

    public function updateValidationStatus(array $elements)
    {
    }

}
