<?php

namespace spec\DeForm\Factory;

use DeForm\Node\NodeInterface as Node;
use DeForm\Request\RequestInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElementFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Factory\ElementFactory');
    }

    function let(RequestInterface $request)
    {
        $this->beConstructedWith($request);
    }


    function it_should_parse_non_group_elements(Node $node1, Node $node2, Node $node3, Node $node4, Node $node5)
    {
        // Todo: add select node
        $node1->getElementType()->shouldBeCalled()->willReturn('input_text');
        $node2->getElementType()->shouldBeCalled()->willReturn('input_password');
        $node3->getElementType()->shouldBeCalled()->willReturn('input_file');
        $node4->getElementType()->shouldBeCalled()->willReturn('input_hidden');
        $node5->getElementType()->shouldBeCalled()->willReturn('textarea');

        $node1->getAttribute('name')->willReturn('input1');
        $node2->getAttribute('name')->willReturn('input2');
        $node3->getAttribute('name')->willReturn('input3');
        $node4->getAttribute('name')->willReturn('input4');
        $node5->getAttribute('name')->willReturn('input5');

        $this->createFromNodes(func_get_args())->shouldReturnNodes([
            'input1' => 'DeForm\\Element\\TextElement',
            'input2' => 'DeForm\\Element\\TextElement',
            'input3' => 'DeForm\\Element\\FileElement',
            'input4' => 'DeForm\\Element\\TextElement',
            'input5' => 'DeForm\\Element\\TextareaElement',
        ]);
    }

    function it_should_parse_radio_elements(Node $node1, Node $node2, Node $node3, Node $node4, Node $node5)
    {
        foreach (func_get_args() as $node) {
            $node->getElementType()->shouldBeCalled()->willReturn('input_radio');
        }

        $node1->getAttribute('name')->willReturn('foo');
        $node2->getAttribute('name')->willReturn('foo');
        $node3->getAttribute('name')->willReturn('foo');
        $node4->getAttribute('name')->willReturn('bar');
        $node5->getAttribute('name')->willReturn('bar');

        $this->createFromNodes(func_get_args())->shouldReturnGroupsNodes([
            'foo' => [
                'className' => 'DeForm\\Element\\RadioGroupElement',
                'length' => 3,
            ],
            'bar' => [
                'className' => 'DeForm\\Element\\RadioGroupElement',
                'length' => 2,
            ],
        ]);
    }

    function it_should_parse_non_groups_checkbox_elements(Node $node1, Node $node2, Node $node3)
    {
        foreach (func_get_args() as $node) {
            $node->getElementType()->shouldBeCalled()->willReturn('input_checkbox');
        }

        $node1->getAttribute('name')->willReturn('foo1');
        $node2->getAttribute('name')->willReturn('foo2');
        $node3->getAttribute('name')->willReturn('foo3');

        $this->createFromNodes(func_get_args())->shouldReturnNodes([
            'foo1' => 'DeForm\\Element\\CheckboxElement',
            'foo2' => 'DeForm\\Element\\CheckboxElement',
            'foo3' => 'DeForm\\Element\\CheckboxElement',
        ]);
    }

    function it_should_parse_groups_checkbox_elements(Node $node1, Node $node2, Node $node3, Node $node4, Node $node5)
    {
        foreach (func_get_args() as $node) {
            $node->getElementType()->shouldBeCalled()->willReturn('input_checkbox');
        }

        $node1->getAttribute('name')->willReturn('foo');
        $node2->getAttribute('name')->willReturn('foo');
        $node3->getAttribute('name')->willReturn('foo');
        $node4->getAttribute('name')->willReturn('bar');
        $node5->getAttribute('name')->willReturn('bar');

        $this->createFromNodes(func_get_args())->shouldReturnGroupsNodes([
            'foo' => [
                'className' => 'DeForm\\Element\\CheckboxGroupElement',
                'length' => 3,
            ],
            'bar' => [
                'className' => 'DeForm\\Element\\CheckboxGroupElement',
                'length' => 2,
            ],
        ]);
    }

    function it_should_parse_mixed_checkbox_elements(Node $node1, Node $node2, Node $node3, Node $node4, Node $node5, Node $node6)
    {
        foreach (func_get_args() as $node) {
            $node->getElementType()->shouldBeCalled()->willReturn('input_checkbox');
        }

        $node1->getAttribute('name')->willReturn('foo');
        $node2->getAttribute('name')->willReturn('foo');
        $node3->getAttribute('name')->willReturn('foo');
        $node4->getAttribute('name')->willReturn('bar');
        $node5->getAttribute('name')->willReturn('bar');
        $node6->getAttribute('name')->willReturn('foobar');

        $this->createFromNodes(func_get_args())->shouldReturnMixedNodes([
            'foo' => [
                'className' => 'DeForm\\Element\\CheckboxGroupElement',
                'length' => 3,
            ],
            'bar' => [
                'className' => 'DeForm\\Element\\CheckboxGroupElement',
                'length' => 2,
            ],
            'foobar' => 'DeForm\\Element\\CheckboxElement',
        ]);
    }

    function getMatchers()
    {
        return [
            'returnNodes' => function ($values, $classNames) {
                $length = count($values);

                if ($length !== count($classNames)) {
                    return false;
                }

                foreach ($classNames as $name => $instance) {
                    $value = $values[$name];

                    if (get_class($value) !== $instance) {
                        return false;
                    }
                }

                return true;
            },
            'returnGroupsNodes' => function ($values, $expectedObject) {
                $expected_objects_count = 0;
                $values_elements_count = 0;

                foreach ($expectedObject as $group_name => $object_details) {
                    $received_class = $values[$group_name];

                    if (get_class($received_class) !== $object_details['className']) {
                        return false;
                    }

                    $expected_objects_count += $object_details['length'];
                    $values_elements_count += $received_class->countElements();
                }

                if ($expected_objects_count !== $values_elements_count) {
                    return false;
                }

                return true;
            },
            'returnMixedNodes' => function ($values, $expectedObject) {
                $nodes_values = [];
                $nodes_expected = [];

                $groups_values = [];
                $groups_expected = [];

                foreach ($expectedObject as $name => $details) {
                    if (true === is_array($details)) {
                        $var_name = 'groups_values';
                        $groups_expected[] = $details;
                    } else {
                        $var_name = 'nodes_values';
                        $nodes_expected[] = $details;
                    }

                    ${$var_name}[] = $values[$name];
                }

                $matchers = $this->getMatchers();

                $return_nodes_function = $matchers['returnNodes'];
                $return_nodes = $return_nodes_function($nodes_values, $nodes_expected);

                $return_groups_function = $matchers['returnGroupsNodes'];
                $return_groups = $return_groups_function($groups_values, $groups_expected);

                return $return_nodes && $return_groups;
            }
        ];
    }
}
