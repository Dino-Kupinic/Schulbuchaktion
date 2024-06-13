<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookOrdersTest extends WebTestCase
{
  public function testGetBookOrders()
  {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/bookOrders/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testGetBookOrder() {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/bookOrders/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testPostBookOrder() {
    $client = static::createClient();

    try {
      $client->request('POST', 'api/v1/bookOrders/create', [], [], ['CONTENT_TYPE' => 'application/json'], '{"book_id": 2, "order_id": 2}');
      $this->assertEquals(201, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testDeleteBookOrder() {
    $client = static::createClient();

    try {
      $client->request('DELETE', 'api/v1/bookOrders/delete/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testUpdateBookOrder() {
    $client = static::createClient();

    try {
      $client->request('PUT', 'api/v1/bookOrders/update/1', [], [], ['CONTENT_TYPE' => 'application/json'], '{"book_id": 2, "order_id": 2}');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }
}
