<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\PageLoader;
use GuzzleHttp\Client;

class PageLoaderTest extends TestCase
{

    private string $path;
    private string $url;

    public function setUp(): void
    {
        $this->path = __DIR__ . '/../src/';
        $this->url = 'https://ru.hexlet.io/courses';
    }

    public function testLoader(): void
    {
        $stub = $this->createMock(Client::class);

        $pageLoader = new PageLoader($this->path, $this->url);
        $result = $pageLoader->loader($stub);
        $this->assertEquals($this->path . 'ru-hexlet-io-courses.html', $result);
    }
}
