<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PublishersTest extends WebTestCase
{
  public function testGetPublishers()
  {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/publishers/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testGetPublisher() {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/publishers/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }
}
