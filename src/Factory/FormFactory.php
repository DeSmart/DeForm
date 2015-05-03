<?php namespace DeForm\Factory;

use DeForm\DeForm;
use DeForm\Factory\ElementFactory;
use DeForm\ValidationHelper as Validator;
use DeForm\Factory\ParserFactoryInterface;
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
     * @var \DeForm\Factory\ParserFactoryInterface
     */
    protected $parserFactory;

    public function __construct(
        Request $request,
        Validator $validator,
        ElementFactory $elementFactory,
        ParserFactoryInterface $parserFactory
    ) {
        $this->elementFactory = $elementFactory;
        $this->request = $request;
        $this->validator = $validator;
        $this->parserFactory = $parserFactory;
    }

    /**
     * Creates new DeForm object
     *
     * @param string $html
     * @return \DeForm\DeForm
     */
    public function make($html)
    {
        $document = $this->parserFactory->createDocument($html);
        $parser = $this->parserFactory->createParser($document);

        $form_node = $parser->getFormNode();
        $hidden_input = $form_node->createElement('input');
        $hidden_input->setAttribute('type', 'hidden');
        $hidden_input->setAttribute('value', $form_node->getAttribute('name'));
        $hidden_input->setAttribute('name', DeForm::DEFORM_ID);
        $form_node->appendChild($hidden_input);

        $form = new DeForm($form_node, $document, $this->request, $this->validator);
        $elements = $this->elementFactory->createFromNodes($parser->getElementsNodes());

        array_walk($elements, [$form, 'addElement']);

        return $form;
    }
}
