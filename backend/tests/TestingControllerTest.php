<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestingControllerTest extends WebTestCase
{
    public function testJson(): void
    {
        $client = self::createClient();
        $client->request('GET', '/test/example');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonStringEqualsJsonString('{"name":"John"}', $client->getResponse()->getContent());
    }
}
