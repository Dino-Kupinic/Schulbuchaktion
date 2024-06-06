<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\Translation\t;

class PublisherFixture extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 5; $i++) {
      $publisher = new Publisher();
      $publisher->setName('Publisher ' . $i);
      $publisher->setPublisherNumber('1234567890');
      $manager->persist($publisher);
      $this->addReference('publisher ' . $i, $publisher);
    }

    $manager->flush();
  }
}
