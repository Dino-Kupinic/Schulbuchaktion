<?php

namespace App\DataFixtures;

use App\Entity\Department;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixture extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 50; $i++) {
      $department = new Department();
      $department->setName('Department ' . $i);
      $department->setBudget(1000);
      $department->setUsedBudget(500);
      $department->setValidFrom(new DateTime('2021-01-01'));
      if ($i != 2) {
        $department->setValidTo(new DateTime('2021-12-31'));
      }
      $manager->persist($department);
      $this->addReference('department ' . $i, $department);
    }

    $manager->flush();
  }
}
