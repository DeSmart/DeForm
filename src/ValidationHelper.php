<?php namespace DeForm;

use DeForm\Validation\ValidatorFactoryInterface;

class ValidationHelper
{

    /**
     * @var ValidatorFactoryInterface
     */
    protected $factory;

    /**
     * @var array
     */
    protected $lastValidationMessages = [];

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
        $validator = $this->factory->make($rules);
        $status = $validator->validate($values);

        $this->lastValidationMessages = $validator->getMessages();

        return $status;
    }

    /**
     * Mark every element as valid or invalid.
     *
     * @param array $elements
     * @return void
     */
    public function updateValidationStatus(array $elements)
    {
        foreach ($elements as $name => $element) {
            if (false === array_key_exists($name, $this->lastValidationMessages)) {
                $element->setValid();
            } else {
                $error = json_encode($this->lastValidationMessages[$name]);
                $element->setInvalid($error);
            }
        }
    }
}
