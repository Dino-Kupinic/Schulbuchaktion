<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\SchoolClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SchoolClassFixture extends Fixture
{
  /**
   * @throws \Exception
   */
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 5; $i++) {
      $schoolClass = new SchoolClass();
      $schoolClass->setName($i . 'A');
      $schoolClass->setGrade($i);
      $schoolClass->setDepartment($this->getReference('department ' . $i));
      $schoolClass->setYear($this->getReference('year ' . $i));
      $schoolClass->setStudents(20);
      $schoolClass->setBudget(500);
      $schoolClass->setUsedBudget(250);
      $schoolClass->setRepetents(2);
      $manager->persist($schoolClass);
      $this->addReference('schoolClass ' . $i, $schoolClass);
    }

    $manager->flush();
  }
}
