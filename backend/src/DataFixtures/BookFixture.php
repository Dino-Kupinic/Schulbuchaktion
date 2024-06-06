<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixture extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < 5; $i++) {
      $book = new Book();
      $book->setTitle('Book ' . $i);
      $book->setPublisher($this->getReference("publisher " . $i));
      $book->setOrderNumber(random_int(1000, 999999999));
      $book->setYear($this->getReference('year ' . $i));
      $book->setSubject($this->getReference('subject ' . $i));
      $book->setEbook(true);
      $book->setEbookPlus(false);
      $book->setSchoolForm(9999);
      $book->setBookPrice(50);
      $book->setGrade("Grade " . $i);
      $manager->persist($book);

      $this->addReference('book ' . $i, $book);
    }

    $manager->flush();
  }


  public function getDependencies()
  {
    return [
      PublisherFixture::class,
    ];
  }
}
