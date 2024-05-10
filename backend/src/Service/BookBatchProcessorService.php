<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Service class for processing a batch of books.
 *
 * @author Dino Kupinic
 * @version 1.0
 * @see Book
 * @see BookRepository
 * @see ImportService
 * @see ImportController
 */
class BookBatchProcessorService
{
  private EntityManagerInterface $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * Processes a batch of books.
   *
   * @param array $books
   */
  public function processBatch(array $books): void
  {
    foreach ($books as $book) {
      $this->entityManager->persist($book);
    }
    $this->entityManager->flush();
  }
}
