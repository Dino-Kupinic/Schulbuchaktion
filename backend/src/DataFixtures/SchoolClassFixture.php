<?php

namespace App\DataFixtures;

use App\Entity\SchoolClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

class SchoolClassFixture extends Fixture
{
  /**
   * Load data fixtures with the passed EntityManager
   * @throws RandomException
   */
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 50; $i++) {
      $schoolClass = new SchoolClass();
      $schoolClass->setName($i . 'AHITN');
      $schoolClass->setGrade($i);
      $schoolClass->setDepartment($this->getReference('department ' . $i));
      $schoolClass->setYear($this->getReference('year ' . $i));
      $schoolClass->setStudents(20);
      $schoolClass->setRepetents(2);
      $schoolClass->setBudget(5000);
      $schoolClass->setUsedBudget(random_int(0, 5000));
      $manager->persist($schoolClass);
      $this->addReference('schoolClass ' . $i, $schoolClass);
    }

    $manager->flush();
  }
}
