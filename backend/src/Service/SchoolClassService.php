<?php

namespace App\Service;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use Doctrine\ORM\EntityManagerInterface;

class SchoolClassService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createSchoolClass($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassAdd = new SchoolClass();
    $schoolClassAdd->setName($schoolClass->getName());
    $schoolClassAdd->setGrade($schoolClass->getGrade());
    $schoolClassAdd->setStudents($schoolClass->getStudents());
    $schoolClassAdd->setRepetents($schoolClass->getRepetents());
    $schoolClassAdd->setBudget($schoolClass->getBudget());
    $schoolClassAdd->setUsedBudget($schoolClass->getUsedBudget());
    $schoolClassAdd->setDepartment($schoolClass->getDepartment());
    $schoolClassAdd->setYear($schoolClass->getYear());
    $em->persist($schoolClassAdd);
    $em->flush();
  }

  public function updateSchoolClass($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassUpdate = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassUpdate->setName($schoolClass->getName());
    $schoolClassUpdate->setGrade($schoolClass->getGrade());
    $schoolClassUpdate->setStudents($schoolClass->getStudents());
    $schoolClassUpdate->setRepetents($schoolClass->getRepetents());
    $schoolClassUpdate->setBudget($schoolClass->getBudget());
    $schoolClassUpdate->setUsedBudget($schoolClass->getUsedBudget());
    $schoolClassUpdate->setDepartment($schoolClass->getDepartment());
    $schoolClassUpdate->setYear($schoolClass->getYear());
    $em->flush();
  }

  public function dropSchoolClass($id, EntityManagerInterface $em): void
  {
    $schoolClass = $em->getRepository(SchoolClass::class)->find($id);
    $em->remove($schoolClass);
    $em->flush();
  }

  public function getSchoolClasses(SchoolClassRepository $schoolClassRepository): array
  {
    return $schoolClassRepository->findAll();
  }

  public function getSchoolClassById($id, SchoolClassRepository $schoolClassRepository): SchoolClass
  {
    return $schoolClassRepository->find($id);
  }

  public function getStudentCount($id, SchoolClassRepository $schoolClassRepository): int
  {
    $schoolClass = $schoolClassRepository->find($id);
    return $schoolClass->getStudents() + $schoolClass->getRepetents();
  }

  public function updateSchoolClassDepartment($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassDepartment = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassDepartment->setDepartment($schoolClass->getDepartment());
    $em->flush();
  }

  public function updateSchoolClassName($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassName = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassName->setName($schoolClass->getName());
    $em->flush();
  }

  public function updateSchoolClassGrade($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassGrade = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassGrade->setGrade($schoolClass->getGrade());
    $em->flush();
  }

  public function updateSchoolClassStudentCount($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassStudentCount = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassStudentCount->setStudents($schoolClass->getStudents());
    $em->flush();
  }

  public function updateSchoolClassRepetents($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassRepetents = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassRepetents->setRepetents($schoolClass->getRepetents());
    $em->flush();
  }

  public function updateSchoolClassBudget($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassBudget = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassBudget->setBudget($schoolClass->getBudget());
    $em->flush();
  }

  public function updateSchoolClassUsedBudget($schoolClass, EntityManagerInterface $em): void
  {
    $schoolClassUsedBudget = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassUsedBudget->setUsedBudget($schoolClass->getUsedBudget());
    $em->flush();
  }

}
