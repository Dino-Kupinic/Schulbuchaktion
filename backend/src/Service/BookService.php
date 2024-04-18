<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createBook($book, EntityManagerInterface $em)
  {
    $bookAdd = new Book();
    $bookAdd->setOrderNumber($book->getOrderNumber());
    $bookAdd->setYear($book->getYear());
    $bookAdd->setSubject($book->getSubject());
    $bookAdd->setPublisher($book->getPublisher());
    $bookAdd->setShortTitle($book->getShortTitle());
    $bookAdd->setTitle($book->getTitle());
    $bookAdd->setSchoolForm($book->getSchoolForm());
    $bookAdd->setDescription($book->getDescription());
    $bookAdd->setBookPrice($book->getBookPrice());
    $bookAdd->setEbook($book->getEbook());
    $bookAdd->setEbookPlus($book->getEbookPlus());
    $bookAdd->setGrade($book->getGrade());
    $em->persist($bookAdd);
    $em->flush();
  }

  public function updateBook($book, EntityManagerInterface $em)
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

  public function dropBook($id, EntityManagerInterface $em)
  {
    $book = $em->getRepository(Book::class)->find($id);
    $em->remove($book);
    $em->flush();
  }

  public function getBooks(BookRepository $bookRepository)
  {
    return $bookRepository->findAll();
  }

  public function getBookById($id, BookRepository $bookRepository)
  {
    return $bookRepository->find($id);
  }

  public function updateBookOrderNumber($book, EntityManagerInterface $em)
  {
    $bookOrderNumber = $em->getRepository(Book::class)->find($book->getId());
    $bookOrderNumber->setOrderNumber($book->getOrderNumber());
    $em->flush();
  }

  public function updateBookYear($book, EntityManagerInterface $em)
  {
    $bookYear = $em->getRepository(Book::class)->find($book->getId());
    $bookYear->setYear($book->getYear());
    $em->flush();
  }

  public function updateBookSubject($book, EntityManagerInterface $em)
  {
    $bookSubject = $em->getRepository(Book::class)->find($book->getId());
    $bookSubject->setSubject($book->getSubject());
    $em->flush();
  }

  public function updateBookPublisher($book, EntityManagerInterface $em)
  {
    $bookPublisher = $em->getRepository(Book::class)->find($book->getId());
    $bookPublisher->setPublisher($book->getPublisher());
    $em->flush();
  }

  public function updateBookShortTitle($book, EntityManagerInterface $em)
  {
    $bookShortTitle = $em->getRepository(Book::class)->find($book->getId());
    $bookShortTitle->setShortTitle($book->getShortTitle());
    $em->flush();
  }

  public function updateBookTitle($book, EntityManagerInterface $em)
  {
    $bookTitle = $em->getRepository(Book::class)->find($book->getId());
    $bookTitle->setTitle($book->getTitle());
    $em->flush();
  }

  public function updateBookSchoolForm($book, EntityManagerInterface $em)
  {
    $bookSchoolForm = $em->getRepository(Book::class)->find($book->getId());
    $bookSchoolForm->setSchoolForm($book->getSchoolForm());
    $em->flush();
  }

  public function updateBookDescription($book, EntityManagerInterface $em)
  {
    $bookDescription = $em->getRepository(Book::class)->find($book->getId());
    $bookDescription->setDescription($book->getDescription());
    $em->flush();
  }

  public function updateBookPrice($book, EntityManagerInterface $em)
  {
    $bookPrice = $em->getRepository(Book::class)->find($book->getId());
    $bookPrice->setBookPrice($book->getBookPrice());
    $em->flush();
  }

  public function updateBookEbook($book, EntityManagerInterface $em)
  {
    $bookEbook = $em->getRepository(Book::class)->find($book->getId());
    $bookEbook->setEbook($book->getEbook());
    $em->flush();
  }

  public function updateBookEbookPlus($book, EntityManagerInterface $em)
  {
    $bookEbookPlus = $em->getRepository(Book::class)->find($book->getId());
    $bookEbookPlus->setEbookPlus($book->getEbookPlus());
    $em->flush();
  }

  public function updateBookGrade($book, EntityManagerInterface $em)
  {
    $bookGrade = $em->getRepository(Book::class)->find($book->getId());
    $bookGrade->setGrade($book->getGrade());
    $em->flush();
  }

}
