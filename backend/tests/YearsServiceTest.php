<?php

namespace App\Tests;

use App\Entity\Years;
use App\Repository\YearsRepository;
use App\Service\YearsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class YearsServiceTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);

      $year1 = ObjectFactory::createYear();

      try {
        $yearsService = new YearsService();

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
          ->method('persist')
          ->with($this->equalTo($year1));

        $em->expects($this->once())
          ->method('flush');

        $yearsService->createYear($year1, $em);
      } finally {
        restore_exception_handler();
      }
    }

  /**
   * @throws Exception
   */
  public function testGetYear(): void
  {
    $yearsService = new YearsService();
    $yearsRepository = $this->createMock(YearsRepository::class);
    $expectedResult = [new Years(), new Years()];

    $yearsRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $result = $yearsService->getYears($yearsRepository);

    $this->assertSame($expectedResult, $result);
  }
}
