<?php

namespace App\Service;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service class for handling Department data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Department
 * @see DepartmentRepository
 */
class DepartmentService
{
  private EntityManagerInterface $entityManager;
  private DepartmentRepository $departmentRepository;

  public function __construct(EntityManagerInterface $entityManager, DepartmentRepository $departmentRepository)
  {
    $this->entityManager = $entityManager;
    $this->departmentRepository = $departmentRepository;
  }

  /**
   * Create a new department.
   *
   * @param Department $department The department object to persist
   * @return Department The persisted department object
   * @throws Exception If the department already exists
   */
  public function createDepartment(Department $department): Department
  {
    $temp = $this->findDepartmentByName($department->getName());
    if ($temp != null) {
      throw new Exception("Department with name " . $department->getName() . " already exists.");
    }
    $this->entityManager->persist($department);
    $this->entityManager->flush();
    return $department;
  }

  /**
   * Update a department.
   *
   * @param int $id The id of the department to delete
   * @param Department $department The department object to update
   * @return Department The updated department object
   */
  public function updateDepartment(int $id, Department $department): Department
  {
    $oldDepartment = $this->findDepartmentById($id);

    if ($oldDepartment) {
      $oldDepartment->updateFrom($department);
      $this->entityManager->persist($oldDepartment);
      $this->entityManager->flush();
    }

    return $oldDepartment;
  }

  /**
   * Parse request data into a Department object.
   *
   * @param Request $request The request object
   * @return Department The department object
   * @throws Exception If the date cannot be parsed
   */
  public function parseRequestData(Request $request): Department
  {
    $data = json_decode($request->getContent(), true);
    if (!isset($data["name"]) || !isset($data["budget"]) || !isset($data["usedBudget"]) || !isset($data["validFrom"]) || !isset($data["validTo"])) {
      throw new Exception("Missing data in request.");
    }
    if (!is_int($data["budget"]) || !is_int($data["usedBudget"])) {
      throw new Exception("Budgets must be numbers.");
    }
    $department = new Department();
    $department->setName($data["name"]);
    $department->setBudget($data["budget"]);
    $department->setUsedBudget($data["usedBudget"]);
    $department->setValidFrom(new DateTime($data["validFrom"]));
    $department->setValidTo(new DateTime($data["validTo"]));
    return $department;
  }

  /**
   * Get all departments.
   *
   * @return Department[]|null The departments
   */
  public function getDepartments(): array|null
  {
    return $this->departmentRepository->findAll();
  }

  /**
   * Find a department by id.
   *
   * @param int $id The id of the department
   * @return Department|null The department
   */
  public function findDepartmentById(int $id): Department|null
  {
    return $this->departmentRepository->find($id);
  }

  /**
   * Find a department by name.
   *
   * @param string $name The name of the department
   * @return Department|null The department
   */
  public function findDepartmentByName(string $name): Department|null
  {
    return $this->departmentRepository->findOneBy(["name" => $name]);
  }
}
