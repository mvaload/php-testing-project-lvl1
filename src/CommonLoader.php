<?php

namespace Hexlet\Code;

use DiDom\Exceptions\InvalidSelectorException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;

/**
 * Class CommonLoader
 * @package Hexlet\Code
 */
class CommonLoader
{
    private string $pathOut;
    private string $url;
    private ClientInterface $client;

    /**
     * @param ClientInterface $client
     * @param string $pathOut
     * @param string $url
     */
    public function __construct(ClientInterface $client, string $pathOut, string $url)
    {
        $this->pathOut = $pathOut;
        $this->url = $url;
        $this->client = $client;
    }

    /**
     * @return string
     * @throws InvalidSelectorException
     * @throws GuzzleException
     */
    public function run(): string
    {
        $pathMainPage = (new PageLoader($this->pathOut, $this->url))->upload($this->client);
        $pathToFiles = (new ImageLoader($this->pathOut, $this->url))->upload($this->client);
        return $pathToFiles;
    }
}