<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Service class for handling book data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Book
 * @see BookRepository
 */
class BookService
{
  private EntityManagerInterface $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  /**
   * Create a new book.
   *
   * @param Book $book
   * @return bool True if successful, false otherwise
   * @throws Exception If an error occurs during transaction
   */
  public function createBook(Book $book): bool
  {
    try {
      $this->em->persist($book);
      $this->em->flush();
    } catch (Exception $e) {
      $this->em->rollback();
      throw $e;
    }
    return true;
  }

  public function updateBook($book, EntityManagerInterface $em): void
  {
    $bookUpdate = $em->getRepository(Book::class)->find($book->getId());
    $bookUpdate->setOrderNumber($book->getOrderNumber());
    $bookUpdate->setYear($book->getYear());
    $bookUpdate->setSubject($book->getSubject());
    $bookUpdate->setPublisher($book->getPublisher());
    $bookUpdate->setShortTitle($book->getShortTitle());
    $bookUpdate->setTitle($book->getTitle());
    $bookUpdate->setSchoolForm($book->getSchoolForm());
    $bookUpdate->setDescription($book->getDescription());
    $bookUpdate->setBookPrice($book->getBookPrice());
    $bookUpdate->setEbook($book->getEbook());
    $bookUpdate->setEbookPlus($book->getEbookPlus());
    $bookUpdate->setGrade($book->getGrade());
    $em->flush();
  }

  public function dropBook($id, EntityManagerInterface $em): void
  {
    $book = $em->getRepository(Book::class)->find($id);
    $em->remove($book);
    $em->flush();
  }

  public function getBooks(BookRepository $bookRepository): array
  {
    return $bookRepository->findAll();
  }

  public function getBookById($id, BookRepository $bookRepository): Book
  {
    return $bookRepository->find($id);
  }

  public function updateBookOrderNumber($book, EntityManagerInterface $em): void
  {
    $bookOrderNumber = $em->getRepository(Book::class)->find($book->getId());
    $bookOrderNumber->setOrderNumber($book->getOrderNumber());
    $em->flush();
  }

  public function updateBookYear($book, EntityManagerInterface $em): void
  {
    $bookYear = $em->getRepository(Book::class)->find($book->getId());
    $bookYear->setYear($book->getYear());
    $em->flush();
  }

  public function updateBookSubject($book, EntityManagerInterface $em): void
  {
    $bookSubject = $em->getRepository(Book::class)->find($book->getId());
    $bookSubject->setSubject($book->getSubject());
    $em->flush();
  }

  public function updateBookPublisher($book, EntityManagerInterface $em): void
  {
    $bookPublisher = $em->getRepository(Book::class)->find($book->getId());
    $bookPublisher->setPublisher($book->getPublisher());
    $em->flush();
  }

  public function updateBookShortTitle($book, EntityManagerInterface $em): void
  {
    $bookShortTitle = $em->getRepository(Book::class)->find($book->getId());
    $bookShortTitle->setShortTitle($book->getShortTitle());
    $em->flush();
  }

  public function updateBookTitle($book, EntityManagerInterface $em): void
  {
    $bookTitle = $em->getRepository(Book::class)->find($book->getId());
    $bookTitle->setTitle($book->getTitle());
    $em->flush();
  }

  public function updateBookSchoolForm($book, EntityManagerInterface $em): void
  {
    $bookSchoolForm = $em->getRepository(Book::class)->find($book->getId());
    $bookSchoolForm->setSchoolForm($book->getSchoolForm());
    $em->flush();
  }

  public function updateBookDescription($book, EntityManagerInterface $em): void
  {
    $bookDescription = $em->getRepository(Book::class)->find($book->getId());
    $bookDescription->setDescription($book->getDescription());
    $em->flush();
  }

  public function updateBookPrice($book, EntityManagerInterface $em): void
  {
    $bookPrice = $em->getRepository(Book::class)->find($book->getId());
    $bookPrice->setBookPrice($book->getBookPrice());
    $em->flush();
  }

  public function updateBookEbook($book, EntityManagerInterface $em): void
  {
    $bookEbook = $em->getRepository(Book::class)->find($book->getId());
    $bookEbook->setEbook($book->getEbook());
    $em->flush();
  }

  public function updateBookEbookPlus($book, EntityManagerInterface $em): void
  {
    $bookEbookPlus = $em->getRepository(Book::class)->find($book->getId());
    $bookEbookPlus->setEbookPlus($book->getEbookPlus());
    $em->flush();
  }

  public function updateBookGrade($book, EntityManagerInterface $em): void
  {
    $bookGrade = $em->getRepository(Book::class)->find($book->getId());
    $bookGrade->setGrade($book->getGrade());
    $em->flush();
  }

}
