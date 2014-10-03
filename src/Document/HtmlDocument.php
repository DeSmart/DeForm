<?php namespace DeForm\Document;

use DeForm\Document\DocumentInterface;

class HtmlDocument implements DocumentInterface {

  /**
   * @var \DOMDocument
   */
  protected $document;
  
  /**
   * Load HTML into document
   *
   * @param string $html
   */
  public function load($html) {
    $this->document = new \DOMDocument();
    $this->document->loadHTML($html);
  }

  /**
   * Convert document to HTML
   *
   * @return string
   */
  public function toHtml() {
    $html = '';
    $nodes_list = $this->document->getElementsByTagName('body')
      ->item(0)
      ->childNodes;

    foreach($nodes_list as $item) {
      $html .= $this->document->saveHTML($item);
    }

    return $html;
  }

  /**
   * Return the loaded DOMDocument.
   * 
   * @return \DOMDocument
   */
  public function getDocument() {
    return $this->document;
  }

}
