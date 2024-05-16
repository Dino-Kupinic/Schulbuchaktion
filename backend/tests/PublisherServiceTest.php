<?php

namespace App\Tests;

use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use App\Service\PublisherService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PublisherServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testPersistPublisher(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());

    try {
      $publisher1 = ObjectFactory::createPublisher();

      $publisherRepository = $this->createMock(PublisherRepository::class);
      $em = $this->createMock(EntityManagerInterface::class);

      $publisherService = new PublisherService($em, $publisherRepository);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($publisher1));

      $em->expects($this->once())
        ->method('flush');

      $publisherService->createPublisher($publisher1, $em);
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
  public function testGetPublishers(): void
  {
    $publisherRepository = $this->createMock(PublisherRepository::class);
    $em = $this->createMock(EntityManagerInterface::class);

    $publisherService = new PublisherService($em, $publisherRepository);
    $expectedResult = [new Publisher(), new Publisher()];

    $publisherRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult); // Set the return value of findAll() to the expected result

    $result = $publisherService->getPublishers();

    $this->assertSame($expectedResult, $result);
  }
}
