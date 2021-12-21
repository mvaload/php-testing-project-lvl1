<?php

namespace Hexlet\Code;

use DiDom\Document;
use Psr\Http\Client\ClientInterface;

/**
 * Class Loader
 * @package Hexlet\Code
 */
abstract class Loader
{
    protected string $pathOut;
    protected string $url;

    /**
     * @param string $pathOut
     * @param string $url
     */
    public function __construct(string $pathOut, string $url)
    {
        $this->pathOut = $pathOut;
        $this->url = $url;
    }

    /**
     * @return string
     */
    protected function getDomainName(): string
    {
        $domainComponents = $this->parserUrl($this->url);
        return $this->nameTransform($domainComponents['host']);
    }

    /**
     * @param string $url
     * @return Document
     */
    protected function parserDom(string $url): Document
    {
        return new Document($url, true);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function nameTransform(string $name): string
    {
        return str_replace(['.', '/'], ['-', '-'],  $name);
    }

    /**
     * @param string $url
     * @return array
     */
    protected function parserUrl(string $url): array
    {
        return parse_url($url);
    }

    /**
     * @param ClientInterface $client
     * @return string
     */
    abstract public function upload(ClientInterface $client): string;
}