<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class SelectElement extends AbstractElement implements ElementInterface
{

    public function __construct(NodeInterface $node)
    {
        $this->node = $node;
    }

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setValue($value)
    {
        if (false === is_array($value)) {
            $values[] = $value;
        } else {
            $values = $value;
        }

        $children_nodes = $this->node->getChildNodes();

        foreach ($children_nodes as $child_node) {
            if (true === in_array($child_node->getAttribute('value'), $values)) {
                $child_node->setAttribute('selected', 'selected');
            } else {
                $child_node->removeAttribute('selected');
            }
        }

    }

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue()
    {
        $value = $this->node->getChildElementByAttribute('selected', 'selected');
        $results = [];

        foreach ($value as $node) {
            $results[] = $node->getAttribute('value');
        }

        return (1 == count($results)) ? $results[0] : $results;
    }

    public function addOption($name, $value = null)
    {
        if (true === is_array($name)) {
            $data = $name;
        } else {
            $data[$value] = $name;
        }

        foreach ($data as $key => $value) {
            $option = $this->node->createElement('option', $value);
            $option->setAttribute('value', $key);
            $this->node->appendChild($option);
        }
    }
}
