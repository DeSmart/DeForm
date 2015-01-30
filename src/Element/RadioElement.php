<?php namespace DeForm\Element;

class RadioElement extends TextElement implements ElementInterface, CheckedElementInterface
{

    /**
     * If element has an attribute "checked" then return true.
     *
     * @return bool
     */
    public function isChecked()
    {
        return $this->node->hasAttribute('checked');
    }

    /**
     * Remove an attribute "checked" from a element.
     *
     * @return self
     */
    public function markAsUnchecked()
    {
        $this->node->removeAttribute('checked');

        return $this;
    }

    /**
     * Add an attribute "checked" to a element.
     *
     * @return self
     */
    public function markAsChecked()
    {
        $this->node->setAttribute('checked', 'checked');

        return $this;
    }

}
