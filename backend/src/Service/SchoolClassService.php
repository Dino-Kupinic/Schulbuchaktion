<?php

namespace App\Service;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class SchoolClassService
{
  private EntityManagerInterface $entityManager;
  private SchoolClassRepository $schoolClassRepository;

  public function __construct(EntityManagerInterface $entityManager, SchoolClassRepository $schoolClassRepository)
  {
    $this->entityManager = $entityManager;
    $this->schoolClassRepository = $schoolClassRepository;
  }


  /**
   * Create a new schoolClass.
   *
   * @param SchoolClass $schoolClass The schoolClass object to persist
   * @return SchoolClass The persisted schoolClass object
   * @throws Exception If an error occurs during transaction
   */
  public function createSchoolClass(SchoolClass $schoolClass): SchoolClass
  {
    $this->entityManager->persist($schoolClass);
    $this->entityManager->flush();
    return $schoolClass;
  }

  /**
   * Update a SchoolClass.
   *
   * @param SchoolClass $schoolClass The book object with updated information
   * @return SchoolClass The updated book object
   * @throws Exception If an error occurs during transaction
   */
  public function updateSchoolClass(SchoolClass $schoolClass): SchoolClass
  {
    $this->entityManager->persist($schoolClass);
    $this->entityManager->flush();
    return $schoolClass;
  }

  /**
   * Delete a SchoolClass.
   *
   * @param int $id The id of the book to delete
   * @throws Exception If an error occurs during transaction
   */
  public function deleteSchoolClass(int $id): void
  {
    $schoolClass = $this->findSchoolClassById($id);
  }

  /**
   * Get all SchoolClasses.
   *
   * @return array|null An array of all SchoolClasses or null if none found
   */
  public function getSchoolClasses(): array|null
  {
    return $this->schoolClassRepository->findAll();
  }

  /**
   * @param int $id The id of the SchoolClass to retrieve
   * @return SchoolClass|null The SchoolClass object or null if not found
   */
  public function findSchoolClassById(int $id): SchoolClass|null
  {
    return $this->schoolClassRepository->find($id);
  }
}
