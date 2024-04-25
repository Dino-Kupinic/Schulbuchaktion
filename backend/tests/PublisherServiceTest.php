<?php

namespace App\Tests;

use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\PublisherService;

class PublisherServiceTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);

      $publisher1 = ObjectFactory::createPublisher();

      try {
        $publisherService = new PublisherService();

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
          ->method('persist')
          ->with($this->equalTo($publisher1));

        $em->expects($this->once())
          ->method('flush');

        $publisherService->createPublisher($publisher1, $em);
      } finally {
        restore_exception_handler();
      }

    }

  /**
   * @throws Exception
   */
  public function testGetPublisher(): void
  {
    $publisherService = new PublisherService();
    $publisherRepository = $this->createMock(PublisherRepository::class);
    $expectedResult = [new Publisher(), new Publisher()];

    $publisherRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $result = $publisherService->getPublishers($publisherRepository);

    $this->assertSame($expectedResult, $result);
  }
}
