<?php namespace DeForm\Document;

class HtmlDocument implements DocumentInterface
{

    /**
     * @var \DOMDocument
     */
    protected $document;

    /**
     * @param string $html
     */
    public function __construct($html)
    {
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        $this->document = new \DOMDocument;
        $this->document->loadHTML($html);
    }

    /**
     * Convert document to HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        $html = null;

        $nodes_list = $this->document->getElementsByTagName('body')
            ->item(0)
            ->childNodes;

        foreach ($nodes_list as $item) {
            $html .= $this->document->saveHTML($item);
        }

        return $html;
    }

    /**
     * Return the loaded DOMDocument.
     *
     * @return \DOMDocument
     */
    public function getDocument()
    {
        return $this->document;
    }

    public function xpath($selector)
    {
        $xpath = new \DOMXPath($this->document);
        $list = $xpath->query($selector);
        $nodes = [];

        foreach ($list as $item) {
            $nodes[] = $item;
        }

        return $nodes;
    }
}
