<?php

namespace App\DataFixtures;

use App\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class YearFixture extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 5; $i++) {
      $year = new Year();
      $year->setYear(2019 + $i);
      $manager->persist($year);
      $this->addReference('year ' . $i, $year);
    }

    $manager->flush();
  }
}
