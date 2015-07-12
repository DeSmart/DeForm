<?php namespace DeForm\Factory;

use DeForm\Element\CheckboxElement;
use DeForm\Element\CheckboxGroupElement;
use DeForm\Element\ElementInterface;
use DeForm\Element\GroupInterface;
use DeForm\Element\RadioElement;
use DeForm\Element\RadioGroupElement;
use DeForm\Node\NodeInterface;
use DeForm\Request\RequestInterface;

class ElementFactory
{

    /**
     * @var \DeForm\Request\RequestInterface
     */
    protected $request;

    /**
     * @var \DeForm\Element\ElementInterface[]
     */
    protected $elements = [];

    /**
     * @var \DeForm\Element\GroupInterface[]
     */
    protected $groups = [];

    /**
     * Map node type to instance of element.
     *
     * @var array
     */
    protected $mapTypes = [
        'input_radio' => 'RadioElement',
        'input_checkbox' => 'CheckboxElement',
        'input_text' => 'TextElement',
        'input_password' => 'TextPasswordElement',
        'input_hidden' => 'TextElement',
        'input_file' => 'FileElement',
        'textarea' => 'TextareaElement',
        'select' => 'SelectElement',
    ];

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @param \DeForm\Node\NodeInterface[] $nodes
     * @return \DeForm\Element\ElementInterface[]
     */
    public function createFromNodes(array $nodes)
    {
        foreach ($nodes as $item) {
            $parsed_element = $this->parseNode($item);

            if (null === $parsed_element) {
                continue;
            }

            $element_name = $parsed_element->getName();

            if ($parsed_element instanceof GroupInterface) {
                $this->groups[$element_name] = $parsed_element;
                continue;
            }

            $this->elements[$element_name] = $parsed_element;
        }

        // Remove groups with single element
        $this->groups = array_filter($this->groups, function (GroupInterface $group) {
            if ($group->countElements() > 1) {
                return true;
            }

            $elements = $group->getElements();
            $this->elements[$elements[0]->getName()] = $elements[0];

            return false;
        });

        return array_merge($this->elements, $this->groups);
    }

    /**
     * Create a new element of form based on node.
     * If necessary method transforms single element to group element.
     *
     * @param NodeInterface $node
     * @return GroupInterface|ElementInterface|null
     */
    protected function parseNode(NodeInterface $node)
    {
        $element = $this->createElement($node);

        if (null === $element) {
            return null;
        }

        if (false === $this->isGroupElement($element)) {
            return $element;
        }

        $group = $this->getGroupByName($element->getName());

        if (null === $group) {
            $group = $this->createGroup($element);
        }

        return $group->addElement($element);
    }

    /**
     * @param string $name
     * @return GroupInterface|null
     */
    protected function getGroupByName($name)
    {
        return array_key_exists($name, $this->groups) ? $this->groups[$name] : null;
    }

    /**
     * @param NodeInterface $node
     * @return \DeForm\Element\ElementInterface|null
     */
    protected function createElement(NodeInterface $node)
    {
        $element_type = $node->getElementType();

        if (false === isset($this->mapTypes[$element_type])) {
            return null;
        }

        $class_name = '\\DeForm\\Element\\' . $this->mapTypes[$element_type];

        if ('input_file' === $element_type) {
            return new $class_name($node, $this->request);
        }

        return new $class_name($node);
    }

    /**
     * @param ElementInterface $element
     * @return \DeForm\Element\GroupInterface
     */
    protected function createGroup(ElementInterface $element)
    {
        if (true === $element instanceof RadioElement) {
            return new RadioGroupElement;
        }

        return new CheckboxGroupElement;
    }

    /**
     * @param ElementInterface $element
     * @return bool
     */
    protected function isGroupElement(ElementInterface $element)
    {
        if ($element instanceof RadioElement) {
            return true;
        }

        if ($element instanceof CheckboxElement) {
            return true;
        }

        return false;
    }
}
