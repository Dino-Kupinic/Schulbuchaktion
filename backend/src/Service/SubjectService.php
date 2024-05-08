<?php

namespace App\Service;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Service class for handling Subject data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Subject
 * @see SubjectRepository
 * @see SubjectController
 */
class SubjectService
{
  private SubjectRepository $subjectRepository;
  private EntityManagerInterface $entityManager;

  public function __construct(SubjectRepository $subjectRepository, EntityManagerInterface $entityManager)
  {
    $this->subjectRepository = $subjectRepository;
    $this->entityManager = $entityManager;
  }

  /**
   * Create a new subject.
   *
   * @param Subject $subject The subject object to persist
   * @return Subject The persisted subject object
   * @throws Exception If the subject already exists
   */
  public function createSubject(Subject $subject): Subject
  {
    $temp = $this->findSubjectById($subject->getName());
    if ($temp != null) {
      throw new Exception("Subject with name " . $subject->getName() . " already exists.");
    }
    $this->entityManager->persist($subject);
    $this->entityManager->flush();

    return $subject;
  }

  /**
   * Update a subject.
   *
   * @param Subject $subject The subject object with updated information
   * @param string $name The new name of the subject
   * @return Subject The updated subject object
   */
  public function updateSubject(Subject $subject, string $name): Subject
  {
    $oldSubject = $this->findSubjectById($subject->getId());

    if ($oldSubject) {
      $oldSubject->setName($name);
      $this->entityManager->persist($subject);
      $this->entityManager->flush();
    }

    return $subject;
  }

  /**
   * Delete a subject.
   *
   * @param Subject $subject The subject object to delete
   */
  public function deleteSubject(Subject $subject): void
  {
    $this->entityManager->remove($subject);
    $this->entityManager->flush();
  }

  /**
   * Get all subjects.
   *
   * @return array|null An array of all subjects or null if none found
   */
  public function getSubjects(): array|null
  {
    return $this->subjectRepository->findAll();
  }

  /**
   * Find a subject by its id.
   *
   * @param int $id The id of the subject to find
   * @return Subject|null The subject object or null if not found
   */
  public function findSubjectById(int $id): Subject|null
  {
    return $this->subjectRepository->find($id);
  }
}
