<?php namespace DeForm\Document;

interface DocumentInterface {

  /**
   * Load HTML into document
   *
   * @param string $html
   */
  public function load($html);

  /**
   * Convert document to HTML
   *
   * @return string
   */
  public function toHtml();
  
  /**
   * Return the loaded DOMDocument.
   * 
   * @return \DOMDocument
   */
  public function getDocument();
  
}
