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
  public function testPersistBook(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());

    $entityManager = $this->createMock(EntityManagerInterface::class);
    $bookRepository = $this->createMock(BookRepository::class);

    $book1 = ObjectFactory::createBook();
    try {
      $bookService = new BookService($entityManager, $bookRepository);

      $em = $this->createMock(EntityManagerInterface::class);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($book1));

      $em->expects($this->once())
        ->method('flush');

      $bookService->createBook($book1);
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
  public function testGetBook(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $bookRepository = $this->createMock(BookRepository::class);
    $expectedResult = [new Book(), new Book()];


    $bookRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $bookService = new BookService($entityManager, $bookRepository);
    $result = $bookService->getBooks();

    $this->assertSame($expectedResult, $result);
  }

  // add test for getting a single book by id

  /**
   * @throws Exception
   */
  public function testGetBookById(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $bookRepository = $this->createMock(BookRepository::class);
    $expectedResult = new Book();

    $bookRepository->expects($this->once())
      ->method('find')
      ->willReturn($expectedResult);

    $bookService = new BookService($entityManager, $bookRepository);
    $result = $bookService->findBookById(1);

    $this->assertSame($expectedResult, $result);
  }

}

