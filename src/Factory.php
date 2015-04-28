<?php namespace DeForm;

use DeForm\Parser\ParserInterface;
use DeForm\Factory\ElementFactory;
use DeForm\ValidationHelper as Validator;
use DeForm\Request\RequestInterface as Request;

class Factory
{

    protected $elementFactory;

    protected $request;

    protected $validator;

    protected $parser;

    public function __construct(
        Request $request,
        Validator $validator,
        ElementFactory $elementFactory,
        ParserInterface $parser
    ) {
        $this->elementFactory = $elementFactory;
        $this->request = $request;
        $this->validator = $validator;
        $this->parser = $parser;
    }

    public function make($html)
    {
        $this->parser->setHtml($html);

        $form_node = $this->parser->getFormNode();
        $hidden_input = $form_node->createElement('input');
        $hidden_input->setAttribute('type', 'hidden');
        $hidden_input->setAttribute('value', $form_node->getAttribute('name'));
        $hidden_input->setAttribute('name', DeForm::DEFORM_ID);
        $form_node->appendChild($hidden_input);

        $form = new DeForm($form_node, $this->request, $this->validator);
        $elements = $this->elementFactory->createFromNodes($this->parser->getElementsNodes());

        array_walk($elements, [$form, 'addElement']);

        return $form;
    }
}
