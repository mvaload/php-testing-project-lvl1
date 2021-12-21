<?php

namespace Hexlet\Code;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;

/**
 * Class PageLoader
 * @package Hexlet\Code
 */
class PageLoader extends Loader
{
    /**
     * @inheritdoc
     * @throws GuzzleException
     */
    public function upload(ClientInterface $client): string
    {
        $domainName = $this->getDomainName();
        $response = $client->request('GET');
        $content = $response->getBody()->getContents();
        $pathToFile = $this->pathOut . $domainName . '.html';
        $this->saveToFile($pathToFile, $content);
        return $pathToFile;
    }

    /**
     * @param string $path
     * @param string $data
     * @throws Exception
     */
    private function saveToFile(string $path, string $data): void
    {
        $result = file_put_contents($path, $data);
        if ($result === false) {
            throw new Exception("Something went wrong");
        }
    }
}
