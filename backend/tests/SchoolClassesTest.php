<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SchoolClassesTest extends WebTestCase
{
  public function testGetSchoolClasses()
  {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/schoolClasses/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testGetSchoolClass() {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/schoolClasses/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testPostSchoolClass() {
    $client = static::createClient();

    try {
      $client->request('POST', 'api/v1/schoolClasses/create', [], [], ['CONTENT_TYPE' => 'application/json'], '{"name": "School Class 1"}');
      $this->assertEquals(201, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testDeleteSchoolClass() {
    $client = static::createClient();

    try {
      $client->request('DELETE', 'api/v1/schoolClasses/delete/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }
}
