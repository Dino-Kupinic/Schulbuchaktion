<?php

namespace App\Service;

use App\Entity\Year;
use App\Repository\YearsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service class for handling year data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Year
 * @see YearsRepository
 * @see YearController
 */
class YearService
{
  private EntityManagerInterface $entityManager;
  private YearsRepository $yearsRepository;

  public function __construct(EntityManagerInterface $entityManager, YearsRepository $yearsRepository)
  {
    $this->entityManager = $entityManager;
    $this->yearsRepository = $yearsRepository;
  }

  /**
   * Create a new year.
   *
   * @param Year $year The year object to persist
   * @return Year The persisted year object
   * @throws Exception If an error occurs during transaction
   */
  public function createYear(Year $year): Year
  {
    $temp = $this->findYearByYear($year->getYear());

    if ($temp != null) {
      throw new Exception("Year with id " . $year->getId() . " already exists.");
    }

    $this->entityManager->persist($year);
    $this->entityManager->flush();
    return $year;
  }

  /**
   * Update a year.
   *
   * @param int $id The id of the year to update
   * @param Year $year The year object to update
   * @return Year The updated year object
   */
  public function updateYear(int $id, Year $year): Year
  {
    $oldYear = $this->findYearById($id);

    if ($oldYear) {
      $oldYear->updateFrom($year);
      $this->entityManager->persist($oldYear);
      $this->entityManager->flush();
    }

    return $oldYear;
  }

  /**
   * Delete a year.
   *
   * @param int $id The id of the year to delete
   * @return Year|null The deleted year object or null if not found
   */
  public function deleteYear(int $id): Year|null
  {
    $year = $this->findYearById($id);

    if ($year) {
      $this->entityManager->remove($year);
      $this->entityManager->flush();
    }

    return $year;
  }

  /**
   * Get all years.
   *
   * @return array|null An array of year objects
   */
  public function getYears(): array|null
  {
    return $this->yearsRepository->findAll();
  }

  /**
   * Find a year by its id.
   *
   * @param int $id The id of the year to find
   * @return Year|null The year object or null if not found
   */
  public function findYearById(int $id): Year|null
  {
    return $this->yearsRepository->find($id);
  }

  /**
   * Parse request data into a year object.
   *
   * @param Request $request The request object
   * @throws Exception If year is not provided or is not a number
   */
  public function parseRequestData(Request $request): Year
  {
    $data = json_decode($request->getContent(), true);

    if (!isset($data['year'])) {
      throw new Exception("Year is required");
    }

    if (!is_int($data['year'])) {
      throw new Exception("Year must be a number");
    }

    $year = new Year();
    $year->setYear($data['year']);

    return $year;
  }

  /**
   * Find a year by its year.
   *
   * @param int|null $getYear The year to find
   * @return Year|null The year object or null if not found
   */
  private function findYearByYear(?int $getYear): Year|null
  {
    return $this->yearsRepository->findOneBy(['year' => $getYear]);
  }
}
