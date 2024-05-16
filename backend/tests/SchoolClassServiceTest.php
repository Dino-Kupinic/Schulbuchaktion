<?php

namespace App\Tests;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use App\Service\SchoolClassService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SchoolClassServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testPersistSchoolClass(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());

    try {
      $schoolClass1 = ObjectFactory::createSchoolClass();

      $schoolClassRepository = $this->createMock(SchoolClassRepository::class);
      $em = $this->createMock(EntityManagerInterface::class);

      $schoolClassService = new SchoolClassService($em, $schoolClassRepository);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($schoolClass1));

      $em->expects($this->once())
        ->method('flush');

      $schoolClassService->createSchoolClass($schoolClass1);
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
  public function testGetSchoolClasses(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $schoolClassRepository = $this->createMock(SchoolClassRepository::class);
    $expectedResult = [new SchoolClass(), new SchoolClass()];

    $schoolClassRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $schoolClassService = new SchoolClassService($entityManager, $schoolClassRepository);
    $result = $schoolClassService->getSchoolClasses();

    $this->assertSame($expectedResult, $result);
  }
}
