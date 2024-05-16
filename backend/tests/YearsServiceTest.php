<?php

namespace App\Tests;

use App\Entity\Year;
use App\Repository\YearsRepository;
use App\Service\YearService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class YearsServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testPersistYear(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());

    try {
      $year1 = ObjectFactory::createYear();

      $yearsRepository = $this->createMock(YearsRepository::class);
      $em = $this->createMock(EntityManagerInterface::class);

      $yearsService = new YearService($em, $yearsRepository);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($year1));

      $em->expects($this->once())
        ->method('flush');

      $yearsService->createYear($year1);
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
  public function testGetYears(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $yearsRepository = $this->createMock(YearsRepository::class);
    $expectedResult = [new Year(), new Year()];

    $yearsRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $yearsService = new YearService($entityManager, $yearsRepository);
    $result = $yearsService->getYears();

    $this->assertSame($expectedResult, $result);
  }
}
