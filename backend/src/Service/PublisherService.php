<?php

namespace App\Service;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;

class PublisherService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createPublisher($publisher, EntityManagerInterface $em)
  {
    $publisherAdd = new Publisher();
    $publisherAdd->setName($publisher->getName());
    $publisherAdd->setPublisherNumber($publisher->getPublisherNumber());
    $em->persist($publisherAdd);
    $em->flush();
  }

  public function updatePublisher($publisher, EntityManagerInterface $em)
  {
    $publisherUpdate = $em->getRepository(Publisher::class)->find($publisher->getId());
    $publisherUpdate->setName($publisher->getName());
    $publisherUpdate->setPublisherNumber($publisher->getPublisherNumber());
    $em->flush();
  }

  public function dropPublisher($id, EntityManagerInterface $em)
  {
    $publisher = $em->getRepository(Publisher::class)->find($id);
    $em->remove($publisher);
    $em->flush();
  }

  public function getPublishers(PublisherRepository $publisherRepository)
  {
    return $publisherRepository->findAll();
  }

  public function getPublisherById($id, PublisherRepository $publisherRepository)
  {
    return $publisherRepository->find($id);
  }

  public function updatePublisherName($publisher, EntityManagerInterface $em)
  {
    $publisherName = $em->getRepository(Publisher::class)->find($publisher->getId());
    $publisherName->setName($publisher->getName());
    $em->flush();
  }

  public function updatePublisherPublisherNumber($publisher, EntityManagerInterface $em)
  {
    $publisherPublisherNumber = $em->getRepository(Publisher::class)->find($publisher->getId());
    $publisherPublisherNumber->setPublisherNumber($publisher->getPublisherNumber());
    $em->flush();
  }

}
