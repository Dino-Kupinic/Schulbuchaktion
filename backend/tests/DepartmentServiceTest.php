<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\BookOrder;
use App\Entity\Department;
use App\Entity\Publisher;
use App\Entity\SchoolClass;
use App\Entity\Subject;
use App\Entity\Years;
use App\Repository\DepartmentRepository;
use App\Service\DepartmentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DepartmentServiceTest extends KernelTestCase
{
  public function testSomething(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());
    // $routerService = static::getContainer()->get('router');
    // $myCustomService = static::getContainer()->get(CustomService::class);

    $department1 = ObjectFactory::createDepartment();

    try {
      $departmentService = new DepartmentService();

      $em = $this->createMock(EntityManagerInterface::class);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($department1));

      $em->expects($this->once())
        ->method('flush');

      $departmentService->createDepartment($department1, $em);
    } finally {
      restore_exception_handler();
    }
  }


    /**
     * @throws Exception
     */
    public function testGetDepartment(): void
    {
      $departmentService = new DepartmentService();
      $departmentRepository = $this->createMock(DepartmentRepository::class);
      $expectedResult = [new Department(), new Department()];

      $departmentRepository->expects($this->once())
        ->method('findAll')
        ->willReturn($expectedResult);

      $result = $departmentService->getDepartments($departmentRepository);

      $this->assertSame($expectedResult, $result);
    }
}
