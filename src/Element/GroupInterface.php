<?php namespace DeForm\Element;

interface GroupInterface extends ElementInterface
{

    /**
     * @param $element
     * @return self
     */
    public function addElement($element);

}