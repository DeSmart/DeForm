<?php namespace spec\DeForm\Document;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlDocumentSpec extends ObjectBehavior {

  function it_is_initializable() {
    $this->shouldHaveType('DeForm\Document\DocumentInterface');
  }
  
  public function it_should_load_a_string_and_convert_it_to_domdocument() {
    $html = '<div><form method="post"><input type="password" name="pwd"></form></div>';
    
    $this->load($html);
    
    $this->getDocument()->shouldHaveType('DOMDocument');
  }
  
  public function it_should_load_a_string_and_return_the_same_string() {
    $html = '<div><form method="post"><input type="password" name="pwd"></form></div>';
    
    $this->load($html);
    
    $this->toHtml()->shouldReturn($html);
  }

}
