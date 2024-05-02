<?php

namespace App\Tests;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Service\BookService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testSomething(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());
    // $routerService = static::getContainer()->get('router');

    $book1 = ObjectFactory::createBook();
    try {
      $bookService = new BookService();

      $em = $this->createMock(EntityManagerInterface::class);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($book1));

      $em->expects($this->once())
        ->method('flush');

      $bookService->createBook($book1, $em);
    } finally {
      restore_exception_handler();
    }
  }

  /**
   * @throws Exception
   */
  public function testGetBook(): void
  {
    $bookService = new BookService();
    $bookRepository = $this->createMock(BookRepository::class);
    $expectedResult = [new Book(), new Book()];

    $bookRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $result = $bookService->getBooks($bookRepository);

    $this->assertSame($expectedResult, $result);
  }
}

