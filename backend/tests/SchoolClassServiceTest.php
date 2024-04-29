<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\BookOrder;
use App\Entity\Department;
use App\Entity\Publisher;
use App\Entity\SchoolClass;
use App\Entity\Subject;
use App\Entity\Years;
use App\Repository\SchoolClassRepository;
use App\Service\SchoolClassService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SchoolClassServiceTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);

      $schoolClass1 = ObjectFactory::createSchoolClass();

      try {
        $schoolClassService = new SchoolClassService();

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
          ->method('persist')
          ->with($this->equalTo($schoolClass1));

        $em->expects($this->once())
          ->method('flush');

        $schoolClassService->createSchoolClass($schoolClass1, $em);
      } finally {
        restore_exception_handler();
      }
    }

  /**
   * @throws Exception
   */
  public function testGetSchoolClass(): void
  {
    $schoolClassService = new SchoolClassService();
    $schoolClassRepository = $this->createMock(SchoolClassRepository::class);
    $expectedResult = [new SchoolClass(), new SchoolClass()];

    $schoolClassRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $result = $schoolClassService->getSchoolClasses($schoolClassRepository);

    $this->assertSame($expectedResult, $result);
  }
}
