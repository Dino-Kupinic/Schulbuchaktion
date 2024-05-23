<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\BookOrder;
use App\Entity\Department;
use App\Entity\Publisher;
use App\Entity\SchoolClass;
use App\Entity\Subject;
use App\Entity\Year;
use App\Repository\DepartmentRepository;
use App\Service\DepartmentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DepartmentServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testPersistDepartment(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());

    try {
      $department1 = ObjectFactory::createDepartment();

      $departmentRepository = $this->createMock(DepartmentRepository::class);
      $em = $this->createMock(EntityManagerInterface::class);

      $departmentService = new DepartmentService($em, $departmentRepository);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($department1));

      $em->expects($this->once())
        ->method('flush');

      $departmentService->createDepartment($department1);
    } catch (Exception $e) {
      $this->fail($e->getMessage());
    } catch (\Exception $e) {
      $this->fail($e->getMessage());
    } finally {
      restore_exception_handler();
    }
  }

  /**
   * @throws Exception
   */
  public function testGetDepartments(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $departmentRepository = $this->createMock(DepartmentRepository::class);
    $expectedResult = [new Department(), new Department()];

    $departmentRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $departmentService = new DepartmentService($entityManager, $departmentRepository);
    $result = $departmentService->getDepartments();

    $this->assertSame($expectedResult, $result);
  }

  /**
   * @throws Exception
   */
  public function testGetDepartmentById(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $departmentRepository = $this->createMock(DepartmentRepository::class);
    $expectedResult = new Department();

    $departmentRepository->expects($this->once())
      ->method('find')
      ->willReturn($expectedResult);

    $departmentService = new DepartmentService($entityManager, $departmentRepository);
    $result = $departmentService->findDepartmentById(1);

    $this->assertSame($expectedResult, $result);
  }
}
