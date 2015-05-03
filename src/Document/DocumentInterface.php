<?php namespace DeForm\Document;

interface DocumentInterface
{

    /**
     * Convert document to HTML.
     *
     * @return string
     */
    public function toHtml();
}
