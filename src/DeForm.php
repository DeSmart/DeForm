<?php namespace DeForm;

use DeForm\Node\NodeInterface;
use DeForm\Request\RequestInterface;
use DeForm\Element\ElementInterface;
use DeForm\Validation\ValidatorFactoryInterface;
use DeForm\Validation\ValidatorInterface;

class DeForm
{

    const DEFORM_ID = '__deform_id';

    /**
     * @var \DeForm\Node\NodeInterface
     */
    protected $formNode;

    /**
     * @var \DeForm\Request\RequestInterface
     */
    protected $request;

    /**
     * @var \DeForm\Element\ElementInterface[]
     */
    protected $elements = [];

    /**
     * @var bool|null
     */
    protected $valid = null;
    
    /**
     * @var ValidationHelper
     */
    protected $validationHelper;

    public function __construct(NodeInterface $formNode, RequestInterface $request, ValidationHelper $validationHelper)
    {
        $this->formNode = $formNode;
        $this->request = $request;
        $this->validationHelper = $validationHelper;
    }

    /**
     * Returns true if the form was submitted, false otherwise.
     *
     * @return boolean
     */
    public function isSubmitted()
    {
        if ($this->formNode->getAttribute('name') === $this->request->get(static::DEFORM_ID)) {
            return true;
        }

        return false;
    }

    /**
     * Registers a new form element.
     *
     * @param \DeForm\Element\ElementInterface $element
     * @return self
     */
    public function addElement(ElementInterface $element)
    {
        $name = $element->getName();

        if (true === array_key_exists($name, $this->elements)) {
            throw new \LogicException(sprintf('Cannot set the element "%s" more than once (same name)', $name));
        }

        $request_value = $this->request->get($name);

        $this->elements[$name] = $element;

        if (true === $this->canSetElementValue($element, $request_value)) {
            $element->setValue($request_value);
        }

        return $this;
    }

    /**
     * Returns a form element by its name.
     *
     * @param string $name
     * @return \DeForm\Element\ElementInterface
     * @throws \LogicException
     */
    public function getElement($name)
    {
        if (false === array_key_exists($name, $this->elements)) {
            throw new \LogicException(sprintf('Trying to get a non-existing element ("%s")', $name));
        }

        return $this->elements[$name];
    }

    /**
     * Returns true if the element's value should be set.
     *
     * @param \DeForm\Element\ElementInterface $element
     * @param string $value
     * @return bool
     */
    protected function canSetElementValue(ElementInterface $element, $value)
    {
        if (false === $this->isSubmitted()) {
            return false;
        }

        if (null === $value) {
            return false;
        }

        if (true === $element->isReadonly()) {
            return false;
        }

        return true;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        if (false === $this->isSubmitted()) {
            return false;
        }

        if (null === $this->valid) {
            $this->validate();
        }

        return $this->valid;
    }

    /**
     * Set form as valid.
     *
     * @return void
     */
    public function setValid()
    {
        $this->valid = true;
    }

    /**
     * Set form as invalid.
     *
     * @return void
     */
    public function setInvalid()
    {
        $this->valid = false;
    }

    /**
     * Force form validation.
     *
     * @return bool
     */
    public function validate()
    {
        $rules = [];

        foreach ($this->elements as $element) {
            $rules[$element->getName()] = $element->getValidationRules();
        }

        $this->valid = $this->validationHelper->validate($rules, $this->getData());
        $this->validationHelper->updateValidationStatus($this->elements);

        return $this->valid;
    }

    /**
     * Returns an array of form element's names combined with element's values.
     *
     * @return array
     */
    public function getData()
    {
        $data = [];

        foreach ($this->elements as $element) {
            $name = $element->getName();

            if (static::DEFORM_ID === $name) {
                continue;
            }

            $data[$name] = $element->getValue();
        }

        return $data;
    }
}
