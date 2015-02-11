<?php namespace DeForm\Element;

trait CheckedAttributeTrait
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
    public function setUnchecked()
    {
        $this->node->removeAttribute('checked');

        return $this;
    }

    /**
     * Add an attribute "checked" to a element.
     *
     * @return self
     */
    public function setChecked()
    {
        $this->node->setAttribute('checked', 'checked');

        return $this;
    }

}