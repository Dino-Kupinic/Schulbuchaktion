<?php

namespace App\Service;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

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
   * Update a book order.
   *
   * @param int $id The id of the book order to update
   * @param BookOrder $bookOrder The book order object to update
   * @return BookOrder The updated book order object
   */
  public function updateBookOrder(int $id, BookOrder $bookOrder): BookOrder
  {
    $oldBookOrder = $this->findBookOrderById($id);

    if ($oldBookOrder) {
      $oldBookOrder->updateFrom($bookOrder);
      $this->entityManager->persist($oldBookOrder);
      $this->entityManager->flush();
    }

    return $oldBookOrder;
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

  /**
   * Parse request data into a BookOrder object.
   *
   * @param Request $request The request object
   * @throws Exception If the data cannot be parsed
   */
  public function parseRequestData(Request $request): BookOrder
  {
    $data = json_decode($request->getContent(), true);

    if (
      !isset($data["count"]) ||
      !isset($data["teacherCopy"]) ||
      !isset($data["lastUser"]) ||
      !isset($data["creationUser"]) ||
      !isset($data["book"]) ||
      !isset($data["year"]) ||
      !isset($data["schoolClass"])
    ) {
      throw new Exception("Missing data in request.");
    }

    if (!is_int($data["count"]) || !is_bool($data["teacherCopy"])) {
      throw new Exception("Count must be a number and/or teacherCopy must be a boolean.");
    }

    $bookOrder = new BookOrder();
    $bookOrder->setCount($data["count"]);
    $bookOrder->setTeacherCopy($data["teacherCopy"]);
    $bookOrder->setLastUser($data["lastUser"]);
    $bookOrder->setCreationUser($data["creationUser"]);
    $bookOrder->setBook($data["book"]);
    $bookOrder->setYear($data["year"]);
    $bookOrder->setSchoolClass($data["schoolClass"]);
    return $bookOrder;
  }
}
