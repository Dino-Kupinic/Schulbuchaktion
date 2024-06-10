<?php

namespace App\DataFixtures;

use App\Entity\SchoolClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SchoolClassFixture extends Fixture
{
  /**
   * Load data fixtures with the passed EntityManager
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
      $schoolClass->setUsedBudget(2500);
      $manager->persist($schoolClass);
      $this->addReference('schoolClass ' . $i, $schoolClass);
    }

    $manager->flush();
  }
}
