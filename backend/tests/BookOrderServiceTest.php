<?php

namespace App\Tests;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use App\Service\BookOrderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookOrderServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testSomething(): void
    {
      $kernel = self::bootKernel();

      $this->assertSame('test', $kernel->getEnvironment());
      // $routerService = static::getContainer()->get('router');

      $bookOrder1 = ObjectFactory::createBookOrder();

      try {
        $bookOrderService = new BookOrderService();

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
          ->method('persist')
          ->with($this->equalTo($bookOrder1));

        $em->expects($this->once())
          ->method('flush');

        $bookOrderService->createBookOrder($bookOrder1, $em);
      } finally {
        restore_exception_handler();
      }
    }


  /**
   * @throws Exception
   */
  public function testGetBookOrders(): void
  {
    $bookOrderService = new BookOrderService();
    $bookOrderRepository = $this->createMock(BookOrderRepository::class);
    $expectedResult = [new BookOrder(), new BookOrder()];

    $bookOrderRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $result = $bookOrderService->getBookOrders($bookOrderRepository);

    $this->assertSame($expectedResult, $result);
  }
}
