<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixture extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 5; $i++) {
      $subject = new Subject();
      $subject->setName('Subject ' . $i);
      $manager->persist($subject);
      $this->addReference('subject ' . $i, $subject);
    }

    $manager->flush();
  }
}
