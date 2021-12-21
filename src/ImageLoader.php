<?php

namespace Hexlet\Code;

use DiDom\Exceptions\InvalidSelectorException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Client\ClientInterface;

/**
 * Class DownloadImages
 * @package Hexlet\Code
 */
class ImageLoader extends Loader
{
    /**
     * @inheritdoc
     * @throws GuzzleException|InvalidSelectorException
     */
    public function upload(ClientInterface $client): string
    {
        $domainName = $this->getDomainName();
        $pathToDir = $this->pathOut . $domainName . '_files/';
        $this->createDir($pathToDir);
        $document = $this->parserDom($this->url);
        $images = $document->find('img.card-img-top::attr(src)');

        foreach ($images as $image) {
            $normalPath = strstr($image, '.', true);
            $fullPath = $pathToDir . $this->nameTransform(substr($normalPath, 1)) . '.png';
            $resource = Utils::tryFopen($fullPath, 'w');
            $response = $client->request('GET', $image, ['sink' => $resource]);
        }
        return $pathToDir;
    }

    /**
     * @param string $path
     * @throws Exception
     */
    public function createDir(string $path): void
    {
        if (!file_exists($path)) {
            $result = mkdir($path);
            if ($result === false) {
                throw new Exception("Something went wrong");
            }
        }
    }
}
