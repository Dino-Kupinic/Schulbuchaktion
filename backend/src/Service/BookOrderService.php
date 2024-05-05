<?php

namespace App\Service;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Service class for handling book orders.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see BookOrder
 * @see BookOrderRepository
 */
class BookOrderService
{
  private EntityManagerInterface $entityManager;
  private BookOrderRepository $bookOrderRepository;

  public function __construct(EntityManagerInterface $entityManager, BookOrderRepository $bookOrderRepository)
  {
    $this->entityManager = $entityManager;
    $this->bookOrderRepository = $bookOrderRepository;
  }

  /**
   * Create a new book order.
   *
   * @param BookOrder $bookOrder The book order object to persist
   * @return BookOrder The persisted book order object
   * @throws Exception If an error occurs during transaction
   */
  public function createBookOrder(BookOrder $bookOrder): BookOrder
  {
    $this->entityManager->persist($bookOrder);
    $this->entityManager->flush();
    return $bookOrder;
  }

  /**
   * Update a new book order.
   *
   * @param BookOrder $bookOrder The book order object with updated information
   * @return BookOrder The updated book order object
   * @throws Exception If an error occurs during transaction
   */
  public function updateBookOrder(BookOrder $bookOrder): BookOrder
  {
    $this->entityManager->persist($bookOrder);
    $this->entityManager->flush();
    return $bookOrder;
  }

  /**
   * Delete a book order.
   *
   * @param int $id The id of the book order to delete
   * @throws Exception If an error occurs during transaction
   */
  public function deleteBookOrder(int $id): void
  {
    $bookOrder = $this->findBookOrderById($id);
    if ($bookOrder === null) {
      throw new Exception("Book order with id $id not found.");
    }
    $this->entityManager->remove($bookOrder);
    $this->entityManager->flush();
  }

  /**
   * Get all book orders.
   *
   * @return array|null The array of book orders or null if not found
   */
  public function getBookOrders(): array|null
  {
    return $this->bookOrderRepository->findAll();
  }

  /**
   * Find a book order by its id.
   *
   * @param int $id The id of the book order to find
   * @return BookOrder|null The book order object or null if not found
   */
  public function findBookOrderById(int $id): BookOrder|null
  {
    return $this->bookOrderRepository->find($id);
  }
}
