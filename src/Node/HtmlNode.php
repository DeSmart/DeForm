<?php namespace DeForm\Node;

class HtmlNode implements NodeInterface
{
  
  /**
   * @var \DOMElement
   */
  protected $element;

  public function __construct(\DOMElement $element) 
  {
    $this->element = $element;
  }
  
  public function appendChild($node) 
  {
    if (false === $node instanceof HtmlNode) {
      throw new \InvalidArgumentException('Unsupported node type');
    }
    
    $this->element->appendChild($node->getDomElement());
  }

  public function getAttribute($name) 
  {
    return $this->element->getAttribute($name);
  }
  
  public function setAttribute($name, $value) 
  {
    $this->element->setAttribute($name, $value);
  }

  public function getElementType() 
  {
    $type = sprintf('%s_%s', $this->element->tagName, $this->element->getAttribute('type'));
    
    return trim($type, '_');
  }

  public function hasAttribute($name) 
  {
    return $this->element->hasAttribute($name);
  }

  public function removeAttribute($name) 
  {
    return $this->element->removeAttribute($name);
  }

  public function getDomElement()
  {
      return $this->element;
  }
  
}
