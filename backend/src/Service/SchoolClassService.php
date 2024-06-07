<?php

namespace App\Service;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service class for handling SchoolClass data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see SchoolClass
 * @see SchoolClassRepository
 * @see SchoolClassController
 */
class SchoolClassService
{
  private EntityManagerInterface $entityManager;
  private SchoolClassRepository $schoolClassRepository;
  private DepartmentService $departmentService;
  private YearService $yearService;

  public function __construct
  (
    EntityManagerInterface $entityManager,
    SchoolClassRepository  $schoolClassRepository,
    DepartmentService      $departmentService,
    YearService            $yearService,
  )
  {
    $this->entityManager = $entityManager;
    $this->schoolClassRepository = $schoolClassRepository;
    $this->departmentService = $departmentService;
    $this->yearService = $yearService;
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
   * Update a schoolClass.
   *
   * @param SchoolClass $schoolClass The schoolClass object to update
   * @return SchoolClass The updated schoolClass object
   * @throws Exception If an error occurs during transaction
   */
  public function updateSchoolClass(SchoolClass $schoolClass): SchoolClass
  {
    $oldSchoolClass = $this->findSchoolClassById($schoolClass->getId());

    if ($oldSchoolClass) {
      $oldSchoolClass->updateFrom($schoolClass);
      $this->entityManager->persist($oldSchoolClass);
      $this->entityManager->flush();
    }

    return $oldSchoolClass;
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
    if ($schoolClass == null) {
      throw new Exception("SchoolClass with id $id not found");
    }
    $this->entityManager->remove($schoolClass);
    $this->entityManager->flush();
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

  /**
   * Validate the request data.
   *
   * @param array $data The request data to validate
   * @throws Exception If the request data is invalid
   */
  private function validateRequestData(array $data): void
  {
    $requiredFields = ["name", "grade", "students", "repetents", "budget", "usedBudget", "department", "year"];
    $intFields = ["grade", "students", "repetents", "budget", "usedBudget", "department", "year"];
    $stringFields = ["name"];

    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) {
        throw new Exception("Missing $field in request data");
      }
    }

    foreach ($intFields as $field) {
      if (!is_int($data[$field])) {
        throw new Exception("$field must be an integer");
      }
    }

    foreach ($stringFields as $field) {
      if (!is_string($data[$field])) {
        throw new Exception("$field must be a string");
      }
    }
  }

  /**
   * Set the properties of a SchoolClass object.
   *
   * @param array $data The data to set
   * @return SchoolClass The SchoolClass object with the properties set
   * @throws Exception If a department or year with the given id is not found
   */
  private function setSchoolClassProperties(array $data): SchoolClass
  {
    $schoolClass = new SchoolClass();
    $schoolClass->setName($data["name"]);
    $schoolClass->setGrade($data["grade"]);
    $schoolClass->setStudents($data["students"]);
    $schoolClass->setRepetents($data["repetents"]);
    $schoolClass->setBudget($data["budget"]);
    $schoolClass->setUsedBudget($data["usedBudget"]);

    $department = $this->departmentService->findDepartmentById($data["department"]);
    if ($department == null) {
      throw new Exception("Department with id {$data["department"]} not found");
    }
    $schoolClass->setDepartment($department);

    $year = $this->yearService->findYearById($data["year"]);
    if ($year == null) {
      throw new Exception("Year with id {$data["year"]} not found");
    }
    $schoolClass->setYear($year);

    return $schoolClass;
  }

  /**
   * Parse the request data.
   *
   * @param Request $request The request to parse
   * @return SchoolClass The SchoolClass object with the request data set
   * @throws Exception If the request data is invalid
   */
  public function parseRequestData(Request $request): SchoolClass
  {
    $data = json_decode($request->getContent(), true);
    $this->validateRequestData($data);
    return $this->setSchoolClassProperties($data);
  }
}
