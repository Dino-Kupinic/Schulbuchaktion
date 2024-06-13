<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepartmentsTest extends WebTestCase
{
  public function testGetDepartments()
  {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/departments/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testGetDepartment() {
    $client = static::createClient();

    try {
      $client->request('GET', 'api/v1/departments/1');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testPostDepartment() {
    $client = static::createClient();

    try {
      $client->request('POST', 'api/v1/departments/create', [], [], ['CONTENT_TYPE' => 'application/json'],
        '"name": "Department Test",
            "budget": 1000,
            "usedBudget": 500');
      $this->assertEquals(201, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }

  public function testUpdateDepartment() {
    $client = static::createClient();

    try {
      $client->request('PUT', 'api/v1/departments/update/1', [], [], ['CONTENT_TYPE' => 'application/json'], '{"name": "Department 2"}');
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      $this->assertJson($client->getResponse()->getContent());
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      restore_exception_handler();
    }
  }
}
