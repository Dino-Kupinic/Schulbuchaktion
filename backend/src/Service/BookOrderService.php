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
  private BookService $bookService;
  private YearService $yearsService;
  private SchoolClassService $schoolClassService;

  public function __construct
  (
    EntityManagerInterface $entityManager,
    BookOrderRepository    $bookOrderRepository,
    BookService            $bookService,
    YearService            $yearsService,
    SchoolClassService     $schoolClassService,
  )
  {
    $this->entityManager = $entityManager;
    $this->bookOrderRepository = $bookOrderRepository;
    $this->bookService = $bookService;
    $this->yearsService = $yearsService;
    $this->schoolClassService = $schoolClassService;
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
   * Validate request data.
   *
   * @param array $data The request data
   * @throws Exception If the data is not valid
   */
  private function validateRequestData(array $data): void
  {
    $requiredFields = ["count", "teacherCopy", "lastUser", "creationUser", "book", "year", "schoolClass"];
    $intFields = ["count", "book", "year", "schoolClass"];
    $boolFields = ["teacherCopy"];
    $stringFields = ["lastUser", "creationUser"];

    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) {
        throw new Exception("Missing $field in request.");
      }
    }

    foreach ($intFields as $field) {
      if (!is_int($data[$field])) {
        throw new Exception("$field must be a number.");
      }
    }

    foreach ($boolFields as $field) {
      if (!is_bool($data[$field])) {
        throw new Exception("$field must be a boolean.");
      }
    }

    foreach ($stringFields as $field) {
      if (!is_string($data[$field])) {
        throw new Exception("$field must be a string.");
      }
    }
  }

  /**
   * Set BookOrder properties.
   *
   * @param array $data The request data
   * @return BookOrder The BookOrder object
   * @throws Exception If an error occurs
   */
  private function setBookOrderProperties(array $data): BookOrder
  {
    $bookOrder = new BookOrder();
    $bookOrder->setCount($data["count"]);
    $bookOrder->setTeacherCopy($data["teacherCopy"]);
    $bookOrder->setLastUser($data["lastUser"]);
    $bookOrder->setCreationUser($data["creationUser"]);

    $book = $this->bookService->findBookById($data["book"]);
    if ($book === null) {
      throw new Exception("Book with id {$data['book']} not found.");
    }
    $bookOrder->setBook($book);

    $year = $this->yearsService->findYearById($data["year"]);
    if ($year === null) {
      throw new Exception("Year with id {$data['year']} not found.");
    }
    $bookOrder->setYear($year);

    $schoolClass = $this->schoolClassService->findSchoolClassById($data["schoolClass"]);
    if ($schoolClass === null) {
      throw new Exception("School class with id {$data['schoolClass']} not found.");
    }
    $bookOrder->setSchoolClass($schoolClass);

    return $bookOrder;
  }

  /**
   * Parse request data into a BookOrder object.
   *
   * @param Request $request The request object
   * @return BookOrder The BookOrder object
   * @throws Exception If the data cannot be parsed
   */
  public function parseRequestData(Request $request): BookOrder
  {
    $data = json_decode($request->getContent(), true);

    $this->validateRequestData($data);

    return $this->setBookOrderProperties($data);
  }
}
