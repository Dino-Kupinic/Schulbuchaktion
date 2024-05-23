<?php

namespace App\Tests;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use App\Service\BookOrderService;
use App\Service\BookService;
use App\Service\SchoolClassService;
use App\Service\YearService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookOrderServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testPersistBookOrder(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());

    try {
      $bookOrder1 = ObjectFactory::createBookOrder();

      $bookOrderRepository = $this->createMock(BookOrderRepository::class);
      $em = $this->createMock(EntityManagerInterface::class);
      $bookService = $this->createMock(BookService::class);
      $yearsService = $this->createMock(YearService::class);
      $schoolClassService = $this->createMock(SchoolClassService::class);

      $bookOrderService = new BookOrderService($em, $bookOrderRepository, $bookService, $yearsService, $schoolClassService);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($bookOrder1));

      $em->expects($this->once())
        ->method('flush');

      $bookOrderService->createBookOrder($bookOrder1);
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
  public function testGetBookOrders(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $bookOrderRepository = $this->createMock(BookOrderRepository::class);
    $bookService = $this->createMock(BookService::class);
    $yearsService = $this->createMock(YearService::class);
    $schoolClassService = $this->createMock(SchoolClassService::class);

    $expectedResult = [new BookOrder(), new BookOrder()];

    $bookOrderRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $bookOrderService = new BookOrderService($entityManager, $bookOrderRepository, $bookService, $yearsService, $schoolClassService);
    $result = $bookOrderService->getBookOrders();

    $this->assertSame($expectedResult, $result);
  }

  /**
   * @throws Exception
   */
  public function testGetBookOrderById(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $bookOrderRepository = $this->createMock(BookOrderRepository::class);
    $bookService = $this->createMock(BookService::class);
    $yearsService = $this->createMock(YearService::class);
    $schoolClassService = $this->createMock(SchoolClassService::class);

    $expectedResult = new BookOrder();

    $bookOrderRepository->expects($this->once())
      ->method('find')
      ->willReturn($expectedResult);

    $bookOrderService = new BookOrderService($entityManager, $bookOrderRepository, $bookService, $yearsService, $schoolClassService);
    $result = $bookOrderService->findBookOrderById(1);

    $this->assertSame($expectedResult, $result);
  }
}
