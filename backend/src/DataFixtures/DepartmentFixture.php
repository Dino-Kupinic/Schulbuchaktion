<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixture extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 5; $i++) {
      $department = new Department();
      $department->setName('Department ' . $i);
      $department->setBudget(1000);
      $department->setUsedBudget(500);
      $manager->persist($department);
      $this->addReference('department ' . $i, $department);
    }

    $manager->flush();
  }
}
