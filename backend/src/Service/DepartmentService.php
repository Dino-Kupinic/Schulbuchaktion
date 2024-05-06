<?php

namespace App\Service;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;

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
   * Get all departments.
   *
   * @return Department[]|null The departments
   */
  public function getDepartments(): array|null
  {
    return $this->departmentRepository->findAll();
  }

  /**
   * Get a department by id.
   *
   * @param int $id The id of the department
   * @return Department|null The department
   */
  public function getDepartmentById(int $id): Department|null
  {
    return $this->departmentRepository->find($id);
  }

  /**
   * Create a new department.
   *
   * @param Department $department The department object to persist
   * @return Department The persisted department object
   */
  public function createDepartment(Department $department): Department
  {
    $this->entityManager->persist($department);
    $this->entityManager->flush();
    return $department;
  }

  /**
   * Update a department.
   *
   * @param Department $department The department object with updated information
   * @return Department The updated department object
   */
  public function updateDepartment(Department $department): Department
  {
    $this->entityManager->persist($department);
    $this->entityManager->flush();
    return $department;
  }

  /**
   * Delete a department.
   *
   * @param int $id The id of the department to delete
   */
  public function deleteDepartment(int $id): void
  {
    $department = $this->departmentRepository->find($id);
    $this->entityManager->remove($department);
    $this->entityManager->flush();
  }
}
