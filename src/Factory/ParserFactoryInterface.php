<?php namespace DeForm\Factory;

interface ParserFactoryInterface
{

    public function createDocument($html);

    public function createParser($document);
}
