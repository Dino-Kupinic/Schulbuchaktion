<?php

namespace App\Service;

use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;

class PublisherService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createPublisher(Publisher $publisher, EntityManagerInterface $em): bool
  {
    try {
      $em->persist($publisher);
      $em->flush();
    } catch (\Exception $e) {
      return false;
    }
    return true;
  }

  public function updatePublisher($publisher, EntityManagerInterface $em): void
  {
    $publisherUpdate = $em->getRepository(Publisher::class)->find($publisher->getId());
    $publisherUpdate->setName($publisher->getName());
    $publisherUpdate->setPublisherNumber($publisher->getPublisherNumber());
    $em->flush();
  }

  public function dropPublisher($id, EntityManagerInterface $em): void
  {
    $publisher = $em->getRepository(Publisher::class)->find($id);
    $em->remove($publisher);
    $em->flush();
  }

  public function getPublishers(PublisherRepository $publisherRepository): array
  {
    return $publisherRepository->findAll();
  }

  public function getPublisherById($id, PublisherRepository $publisherRepository): Publisher
  {
    return $publisherRepository->find($id);
  }

  public function updatePublisherName($publisher, EntityManagerInterface $em): void
  {
    $publisherName = $em->getRepository(Publisher::class)->find($publisher->getId());
    $publisherName->setName($publisher->getName());
    $em->flush();
  }

  public function updatePublisherPublisherNumber($publisher, EntityManagerInterface $em): void
  {
    $publisherPublisherNumber = $em->getRepository(Publisher::class)->find($publisher->getId());
    $publisherPublisherNumber->setPublisherNumber($publisher->getPublisherNumber());
    $em->flush();
  }

}
