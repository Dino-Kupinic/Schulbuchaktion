<?php

namespace App\Service;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;

class DepartmentService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createDepartment($department, EntityManagerInterface $em): void
  {
    $departmentAdd = new Department();
    $departmentAdd->setName($department->getName());
    $departmentAdd->setBudget($department->getBudget());
    $departmentAdd->setUsedBudget($department->getUsedBudget());
    $departmentAdd->setValidFrom($department->getValidFrom());
    $departmentAdd->setValidTo($department->getValidTo());
    $em->persist($departmentAdd);
    $em->flush();
  }

  public function updateDepartment($department, EntityManagerInterface $em): void
  {
    $departmentUpdate = $em->getRepository(Department::class)->find($department->getId());
    $departmentUpdate->setName($department->getName());
    $departmentUpdate->setBudget($department->getBudget());
    $departmentUpdate->setUsedBudget($department->getUsedBudget());
    $departmentUpdate->setValidFrom($department->getValidFrom());
    $departmentUpdate->setValidTo($department->getValidTo());
    $em->flush();
  }

  public function dropDepartment($id, EntityManagerInterface $em): void
  {
    $department = $em->getRepository(Department::class)->find($id);
    $em->remove($department);
    $em->flush();
  }

  public function getDepartments(DepartmentRepository $departmentRepository): array
  {
    return $departmentRepository->findAll();
  }

  public function getDepartmentById($id, DepartmentRepository $departmentRepository): Department
  {
    return $departmentRepository->find($id);
  }

  public function updateDepartmentName($department, EntityManagerInterface $em): void
  {
    $departmentName = $em->getRepository(Department::class)->find($department->getId());
    $departmentName->setName($department->getName());
    $em->flush();
  }

  public function updateDepartmentBudget($department, EntityManagerInterface $em): void
  {
    $departmentBudget = $em->getRepository(Department::class)->find($department->getId());
    $departmentBudget->setBudget($department->getBudget());
    $em->flush();
  }

  public function updateDepartmentUsedBudget($department, EntityManagerInterface $em): void
  {
    $departmentUsedBudget = $em->getRepository(Department::class)->find($department->getId());
    $departmentUsedBudget->setUsedBudget($department->getUsedBudget());
    $em->flush();
  }

  public function updateDepartmentValidFrom($department, EntityManagerInterface $em): void
  {
    $departmentValidFrom = $em->getRepository(Department::class)->find($department->getId());
    $departmentValidFrom->setValidFrom($department->getValidFrom());
    $em->flush();
  }

  public function updateDepartmentValidTo($department, EntityManagerInterface $em): void
  {
    $departmentValidTo = $em->getRepository(Department::class)->find($department->getId());
    $departmentValidTo->setValidTo($department->getValidTo());
    $em->flush();
  }



}
