<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class YearsTest extends WebTestCase
{
  public function testGetYears()
  {

    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/years/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testGetYear() {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/years/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testGetYearsImport() {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/years/import');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testPostYear()
  {
    $client = static::createClient();

    try {
      $client->request('POST', 'api/v1/years/create', [], [], ['CONTENT_TYPE' => 'application/json'], '{"year": 2088}');
      $this->assertEquals(201, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }
}
