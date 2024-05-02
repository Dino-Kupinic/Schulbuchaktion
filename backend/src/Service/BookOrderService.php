<?php

namespace App\Service;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookOrderService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createBookOrder(BookOrder $bookOrder, EntityManagerInterface $em): bool
  {
    try {
      $em->persist($bookOrder);
      $em->flush();
    } catch (\Exception $e) {
      return false;
    }
    return true;
  }

  public function updateBookOrder(BookOrder $bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderUpdate = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderUpdate->setSchoolClass($bookOrder->getSchoolClass());
    $bookOrderUpdate->setBookId($bookOrder->getBookId());
    $bookOrderUpdate->setYear($bookOrder->getYear());
    $bookOrderUpdate->setCount($bookOrder->getCount());
    $bookOrderUpdate->setTeacherCopy($bookOrder->getTeacherCopy());
    $bookOrderUpdate->setLastUser($bookOrder->getLastUser());
    $bookOrderUpdate->setCreationUser($bookOrder->getCreationUser());
    $em->flush();
  }

  public function dropBookOrder($id, EntityManagerInterface $em): void
  {
    $bookOrder = $em->getRepository(BookOrder::class)->find($id);
    $em->remove($bookOrder);
    $em->flush();
  }

  public function getBookOrders(BookOrderRepository $bookOrderRepository): array
  {
    return $bookOrderRepository->findAll();
  }

  public function getBookOrderById($id, BookOrderRepository $bookOrderRepository): BookOrder
  {
    return $bookOrderRepository->find($id);
  }

  public function updateBookOrderSchoolClass($bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderSchoolClass = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderSchoolClass->setSchoolClass($bookOrder->getSchoolClass());
    $em->flush();
  }

  public function updateBookOrderBook($bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderBook = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderBook->setBook($bookOrder->getBook());
    $em->flush();
  }

  public function updateBookOrderYear($bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderYear = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderYear->setYear($bookOrder->getYear());
    $em->flush();
  }

  public function updateBookOrderCount($bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderCount = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderCount->setCount($bookOrder->getCount());
    $em->flush();
  }

  public function updateBookOrderTeacherCopy($bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderTeacherCopy = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderTeacherCopy->setTeacherCopy($bookOrder->getTeacherCopy());
    $em->flush();
  }

  public function updateBookOrderLastUser($bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderLastUser = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderLastUser->setLastUser($bookOrder->getLastUser());
    $em->flush();
  }

  public function updateBookOrderCreationUser($bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderCreationUser = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderCreationUser->setCreationUser($bookOrder->getCreationUser());
    $em->flush();
  }

}
