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
  private EntityManagerInterface $entityManager;
  private BookRepository $bookRepository;

  public function __construct(EntityManagerInterface $entityManager, BookRepository $bookRepository)
  {
    $this->entityManager = $entityManager;
    $this->bookRepository = $bookRepository;
  }

  /**
   * Create a new book.
   *
   * @param Book $book The book object to persist
   * @return Book The persisted book object
   * @throws Exception If an error occurs during transaction
   */
  public function createBook(Book $book): Book
  {
    $this->entityManager->persist($book);
    $this->entityManager->flush();
    return $book;
  }

  /**
   * Update a book.
   *
   * @param Book $book The book object with updated information
   * @return Book The updated book object
   * @throws Exception If an error occurs during transaction
   */
  public function updateBook(Book $book): Book
  {
    $oldBook = $this->findBookById($book->getId());

    if ($oldBook) {
      $oldBook->updateFrom($book);
      $this->entityManager->persist($book);
      $this->entityManager->flush();
    }

    return $book;
  }

  /**
   * Delete a book.
   *
   * @param int $id The id of the book to delete
   * @throws Exception If an error occurs during transaction
   */
  public function deleteBook(int $id): void
  {
    $book = $this->findBookById($id);
    if ($book === null) {
      throw new Exception("Book with id $id not found");
    }
    $this->entityManager->remove($book);
    $this->entityManager->flush();
  }

  /**
   * Get all books.
   *
   * @return array|null An array of all books or null if none found
   */
  public function getBooks(): array|null
  {
    return $this->bookRepository->findAll();
  }

  /**
   * Find a book by its id.
   *
   * @param int $id The id of the book to retrieve
   * @return Book|null The book object or null if not found
   */
  public function findBookById(int $id): Book|null
  {
    return $this->bookRepository->find($id);
  }

  /**
   * Delete books by their ids.
   *
   * @param array $bookIds The ids of the books to delete
   * @return mixed The result of the deletion query
   */
  public function deleteBooksByIds(array $bookIds): mixed
  {
    return $this->bookRepository->deleteBooksByIds($bookIds);
  }

  public function getPaginatedBooks(int $page, int $perPage): array
  {
    $offset = ($page - 1) * $perPage;
    $books = $this->bookRepository->findBy([], null, $perPage, $offset);
    $totalBooks = $this->bookRepository->count();
    return [
      'books' => $books,
      'total' => $totalBooks,
      'perPage' => $perPage,
      'currentPage' => $page
    ];
  }

}
