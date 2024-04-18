<?php

namespace App\Service;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use Doctrine\ORM\EntityManagerInterface;

class SchoolClassService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createSchoolClass($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassAdd = new SchoolClass();
    $schoolClassAdd->setName($schoolClass->getName());
    $schoolClassAdd->setGrade($schoolClass->getGrade());
    $schoolClassAdd->setStudentCount($schoolClass->getStudentCount());
    $schoolClassAdd->setRepetents($schoolClass->getRepetents());
    $schoolClassAdd->setBudget($schoolClass->getBudget());
    $schoolClassAdd->setUsedBudget($schoolClass->getUsedBudget());
    $schoolClassAdd->setDepartment($schoolClass->getDepartment());
    $schoolClassAdd->setYear($schoolClass->getYear());
    $em->persist($schoolClassAdd);
    $em->flush();
  }

  public function updateSchoolClass($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassUpdate = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassUpdate->setName($schoolClass->getName());
    $schoolClassUpdate->setGrade($schoolClass->getGrade());
    $schoolClassUpdate->setStudentCount($schoolClass->getStudentCount());
    $schoolClassUpdate->setRepetents($schoolClass->getRepetents());
    $schoolClassUpdate->setBudget($schoolClass->getBudget());
    $schoolClassUpdate->setUsedBudget($schoolClass->getUsedBudget());
    $schoolClassUpdate->setDepartment($schoolClass->getDepartment());
    $schoolClassUpdate->setYear($schoolClass->getYear());
    $em->flush();
  }

  public function dropSchoolClass($id, EntityManagerInterface $em)
  {
    $schoolClass = $em->getRepository(SchoolClass::class)->find($id);
    $em->remove($schoolClass);
    $em->flush();
  }

  public function getSchoolClasses(SchoolClassRepository $schoolClassRepository)
  {
    return $schoolClassRepository->findAll();
  }

  public function getSchoolClassById($id, SchoolClassRepository $schoolClassRepository)
  {
    return $schoolClassRepository->find($id);
  }

  public function updateSchoolClassDepartment($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassDepartment = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassDepartment->setDepartment($schoolClass->getDepartment());
    $em->flush();
  }

  public function updateSchoolClassName($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassName = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassName->setName($schoolClass->getName());
    $em->flush();
  }

  public function updateSchoolClassGrade($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassGrade = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassGrade->setGrade($schoolClass->getGrade());
    $em->flush();
  }

  public function updateSchoolClassStudentCount($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassStudentCount = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassStudentCount->setStudentCount($schoolClass->getStudentCount());
    $em->flush();
  }

  public function updateSchoolClassRepetents($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassRepetents = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassRepetents->setRepetents($schoolClass->getRepetents());
    $em->flush();
  }

  public function updateSchoolClassBudget($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassBudget = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassBudget->setBudget($schoolClass->getBudget());
    $em->flush();
  }

  public function updateSchoolClassUsedBudget($schoolClass, EntityManagerInterface $em)
  {
    $schoolClassUsedBudget = $em->getRepository(SchoolClass::class)->find($schoolClass->getId());
    $schoolClassUsedBudget->setUsedBudget($schoolClass->getUsedBudget());
    $em->flush();
  }

}
