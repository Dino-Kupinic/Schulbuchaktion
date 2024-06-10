<?php

namespace App\DataFixtures;

use App\Entity\BookOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookOrderFixture extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 50; $i++) {
      $bookOrder = new BookOrder();
      $bookOrder->setBook($this->getReference('book ' . $i));
      $bookOrder->setSchoolClass($this->getReference('schoolClass ' . $i));
      $bookOrder->setYear($this->getReference('year ' . $i));
      $bookOrder->setCount(10);
      $bookOrder->setCreationUser('User ' . $i);
      $bookOrder->setLastUser('User ' . $i);
      $bookOrder->setTeacherCopy(true);
      $manager->persist($bookOrder);
      $this->addReference('bookOrder ' . $i, $bookOrder);
    }

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      YearFixture::class,
      SubjectFixture::class,
      DepartmentFixture::class,
      SchoolClassFixture::class,
      BookFixture::class,
    ];
  }
}
