<?php

namespace Hexlet\Code;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;

/**
 * Class PageLoader
 */
class PageLoader
{
    private string $url;
    private string $fullPath;
    private string $pathToDir;

    public function __construct(string $path, string $url)
    {
        $this->pathToDir = $path;
        $this->url = $url;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function loader(ClientInterface $client): string
    {
        $data = $client->get($this->url)->getBody()->getContents();
        $urlComponents = $this->parserUrl($this->url);
        $this->generateFullPathTofile($urlComponents);
        $this->saveToFile($this->fullPath, $data);
        return $this->fullPath;
    }

    public function parserUrl(string $url): array
    {
        return parse_url($url);
    }

    public function generateFullPathTofile(array $urlComponents): void
    {
        unset($urlComponents['scheme']);
        $nameFile = str_replace(['.', '/'], ['-'], implode('-', $urlComponents));
        $this->fullPath = $this->pathToDir . $nameFile . '.html';
    }

    /**
     * @throws Exception
     */
    public function saveToFile(string $fullPath, string $data): void
    {
        $result = file_put_contents($fullPath, $data);
        if ($result === false) {
            throw new Exception("Something went wrong");
        }
    }
}
