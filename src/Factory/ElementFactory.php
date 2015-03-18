<?php namespace DeForm\Factory;

use DeForm\Element\CheckboxGroupElement;
use DeForm\Element\ElementInterface;
use DeForm\Element\GroupInterface;
use DeForm\Element\RadioElement;
use DeForm\Element\RadioGroupElement;
use DeForm\Element\TextareaValue;
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
     * Map node type to instance of element.
     *
     * @var array
     */
    protected $mapTypes = [
        // TODO: more inputs
        'input_radio' => 'RadioElement',
        'input_checkbox' => 'CheckboxElement',
        'input_text' => 'TextElement',
        'input_password' => 'TextElement',
        'input_hidden' => 'TextElement',
        'input_file' => 'FileElement',
        'textarea' => 'TextareaElement',
        // 'select' => 'SelectElement', TODO: uncomment line
    ];

    /**
     * @var array
     */
    protected $groupElements = [
        'DeForm\Element\RadioElement',
        'DeForm\Element\CheckboxElement',
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
            $this->parseNode($item);
        }

        return $this->elements;
    }

    /**
     * Create a new element of form based on node.
     * If necessary method transforms single element to group element.
     *
     * @param NodeInterface $node
     * @return void
     */
    protected function parseNode(NodeInterface $node)
    {
        $element = $this->createElement($node);

        // Element is not a group element
        if (false === $this->shouldBeGroupElement($element)) {
            $this->elements[$element->getName()] = $element;
            return;
        }

        // Find group based on element
        $group_element = $this->findGroupByElement($element);

        // Group element exists
        if (null !== $group_element) {
            $group_element->addElement($element);
            return;
        }

        // Group element does not exist OR found element is not prepared to be group
        if (null === $group_element) {
            $group_element = $this->createGroup($element);
        } elseif (false === $this->isGroupElement($group_element)) {
            $exist_element = $this->getElementByName($element);
            $group_element->addElement($exist_element);
        }

        $group_element->addElement($element);
        $this->elements[$element->getName()] = $group_element;
    }

    /**
     * @param string $name
     * @return ElementInterface|null
     */
    protected function getElementByName($name)
    {
        return array_key_exists($name, $this->elements) ? $this->elements[$name] : null;
    }

    /**
     * @param NodeInterface $node
     * @return \DeForm\Element\ElementInterface
     */
    protected function createElement(NodeInterface $node)
    {
        $element_type = $node->getElementType();
        $class_name = '\\DeForm\\Element\\' . $this->mapTypes[$element_type];

        if ('input_file' === $element_type) {
            return new $class_name($node, $this->request);
        }

        // TODO: remove this, temporary for tests...
        if ('textarea' === $element_type) {
            $value = new TextareaValue(new \DOMText(''));
            return new $class_name($node, $value);
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
     * @return \DeForm\Element\GroupInterface|null
     */
    protected function findGroupByElement(ElementInterface $element)
    {
        if (false === array_key_exists($element->getName(), $this->elements)) {
            return null;
        }

        $exist_element = $this->getElementByName($element->getName());

        if (false === $this->isGroupElement($exist_element)) {
            return null;
        }

        return $exist_element;
    }

    /**
     * @param ElementInterface $element
     * @return bool
     */
    protected function isGroupElement(ElementInterface $element)
    {
        return $element instanceof GroupInterface;
    }

    /**
     * Return true if element is instance of RadioElement.
     * Can return true if element is instance of CheckboxElement and this name of element is in element keys.
     *
     * @param ElementInterface $element
     * @return boolean
     */
    protected function shouldBeGroupElement(ElementInterface $element)
    {
        $element_class = get_class($element);

        if (false === in_array($element_class, $this->groupElements)) {
            return false;
        }

        if (true === $element instanceof RadioElement) {
            return true;
        }

        return array_key_exists($element->getName(), $this->elements);
    }

}