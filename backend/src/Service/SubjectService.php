<?php

namespace App\Service;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class SubjectService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createSubject($subject, EntityManagerInterface $em)
  {
    $subjectAdd = new Subject();
    $subjectAdd->setName($subject->getName());
    $em->persist($subjectAdd);
    $em->flush();
  }

  public function dropSubject($id, EntityManagerInterface $em)
  {
    $subject = $em->getRepository(Subject::class)->find($id);
    $em->remove($subject);
    $em->flush();
  }

  public function getSubjects(SubjectRepository $subjectRepository)
  {
    return $subjectRepository->findAll();
  }

  public function getSubjectById($id, SubjectRepository $subjectRepository)
  {
    return $subjectRepository->find($id);
  }

  public function updateSubjectName($subject, EntityManagerInterface $em)
  {
    $subjectName = $em->getRepository(Subject::class)->find($subject->getId());
    $subjectName->setName($subject->getName());
    $em->flush();
  }

}
