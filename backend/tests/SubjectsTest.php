<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubjectsTest extends WebTestCase
{
  public function testGetSubjects()
  {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/subjects/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testGetSubject() {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/subjects/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }
}
