<?php

namespace App\Service;

use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Service class for handling Department data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Publisher
 * @see PublisherRepository
 * @see PublisherController
 */
class PublisherService
{
  private EntityManagerInterface $entityManager;
  private PublisherRepository $publisherRepository;

  public function __construct(EntityManagerInterface $entityManager, PublisherRepository $publisherRepository)
  {
    $this->entityManager = $entityManager;
    $this->publisherRepository = $publisherRepository;
  }

  /**
   * Create a new publisher.
   *
   * @param Publisher $publisher The publisher object to persist
   * @return Publisher The persisted publisher object
   * @throws Exception If the publisher already exists
   */
  public function createPublisher(Publisher $publisher): Publisher
  {
    $temp = $this->findPublisherById($publisher->getId());

    if ($temp != null) {
      throw new Exception("Publisher with name " . $publisher->getName() . " already exists.");
    }

    $this->entityManager->persist($publisher);
    $this->entityManager->flush();
    return $publisher;
  }

  /**
   * Update a publisher.
   *
   * @param Publisher $publisher The publisher object to update
   * @return Publisher The updated publisher object
   */
  public function updatePublisher(Publisher $publisher): Publisher
  {
    $oldPublisher = $this->findPublisherById($publisher->getId());

    if ($oldPublisher) {
      $oldPublisher->updateFrom($publisher);
      $this->entityManager->persist($oldPublisher);
      $this->entityManager->flush();
    }

    return $oldPublisher;
  }

  /**
   * Get all publishers.
   *
   * @return array|null The list of all publishers
   */
  public function getPublishers(): array|null
  {
    return $this->publisherRepository->findAll();
  }

  /**
   * Find a publisher by its id.
   *
   * @param int $id The id of the publisher to get
   * @return Publisher|null The publisher object with the given id or null if not found
   */
  public function findPublisherById(int $id): Publisher|null
  {
    return $this->publisherRepository->find($id);
  }
}
