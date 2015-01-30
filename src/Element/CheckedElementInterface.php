<?php
namespace DeForm\Element;

interface CheckedElementInterface
{

    /**
     * If element has an attribute "checked" then return true.
     *
     * @return bool
     */
    public function isChecked();

    /**
     * Remove an attribute "checked" from a element.
     *
     * @return self
     */
    public function markAsUnchecked();

    /**
     * Add an attribute "checked" to a element.
     *
     * @return self
     */
    public function markAsChecked();

}