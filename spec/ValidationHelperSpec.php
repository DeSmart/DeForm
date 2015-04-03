<?php

namespace spec\DeForm;

use DeForm\Element\ElementInterface;
use DeForm\Validation\ValidatorFactoryInterface;
use DeForm\Validation\ValidatorInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidationHelperSpec extends ObjectBehavior
{
    function let(ValidatorFactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\ValidationHelper');
    }

    function it_should_validate_data_and_return_success(ValidatorFactoryInterface $factory, ValidatorInterface $validator, ElementInterface $el)
    {
        $rules = [
            'foo' => 'required',
        ];

        $values = [
            'foo' => 'foobar',
        ];

        $elements = [
            'foo' => $el,
        ];

        $el->getName()->willReturn('foo');
        $el->setValid()->shouldBeCalled();

        $factory->make($rules)->willReturn($validator);
        $validator->validate($values)->willReturn(true);
        $validator->getMessages()->willReturn([]);

        $this->validate($rules, $values)->shouldReturn(true);
        $this->updateValidationStatus($elements);
    }

    function it_should_validate_data_and_return_fail(ValidatorFactoryInterface $factory, ValidatorInterface $validator, ElementInterface $el)
    {
        $rules = [
            'foo' => 'required',
        ];

        $values = [
            'foo' => '',
        ];

        $errors = [
            'foo' => [
                'Foo element is required.',
            ],
        ];

        $elements = [
            'foo' => $el,
        ];

        $factory->make($rules)->willReturn($validator);
        $validator->validate($values)->willReturn(false);
        $validator->getMessages()->willReturn($errors);

        $el->getName()->willReturn('foo');
        $el->setInvalid(json_encode($errors['foo']))->shouldBeCalled();

        $this->validate($rules, $values)->shouldReturn(false);
        $this->updateValidationStatus($elements);
    }

}
