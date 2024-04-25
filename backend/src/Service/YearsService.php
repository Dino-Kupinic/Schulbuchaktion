<?php

namespace App\Service;

use App\Entity\Years;
use App\Repository\YearsRepository;
use Doctrine\ORM\EntityManagerInterface;

class YearsService
{

  // We are not sure what the $department parameter gets. Be aware that this function is not functional at this moment.

  public function createYear(Years $years, EntityManagerInterface $em): void
  {
    $yearsAdd = new Years();
    $yearsAdd->setYear($years->getYear());
    $em->persist($yearsAdd);
    $em->flush();
  }

  public function dropYears($id, EntityManagerInterface $em): void
  {
    $years = $em->getRepository(Years::class)->find($id);
    $em->remove($years);
    $em->flush();
  }

  public function getYears(YearsRepository $yearsRepository): array
  {
    return $yearsRepository->findAll();
  }

  public function getYearsById($id, YearsRepository $yearsRepository): Years
  {
    return $yearsRepository->find($id);
  }

  public function updateYears($years, EntityManagerInterface $em): void
  {
    $yearsUpdate = $em->getRepository(Years::class)->find($years->getId());
    $yearsUpdate->setYear($years->getYear());
    $em->flush();
  }

}
