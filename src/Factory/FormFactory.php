<?php namespace DeForm\Factory;

use DeForm\DeForm;
use DeForm\Node\NodeInterface;
use DeForm\Parser\ParserInterface;
use DeForm\Factory\ElementFactory;
use DeForm\Document\DocumentInterface;
use DeForm\ValidationHelper as Validator;
use DeForm\Request\RequestInterface as Request;

class FormFactory
{

    /**
     * @var \DeForm\Factory\ElementFactory
     */
    protected $elementFactory;

    /**
     * @var \DeForm\Request\RequestInterface
     */
    protected $request;

    /**
     * @var \DeForm\ValidationHelper
     */
    protected $validator;

    /**
     * @var \DeForm\Parser\ParserInterface
     */
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

    /**
     * Creates new DeForm object from document
     *
     * @param \DeForm\Document\DocumentInterface $document
     * @return \DeForm\DeForm
     */
    public function make(DocumentInterface $document)
    {
        $this->parser->setDocument($document);

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
