<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

class BookFixture extends Fixture implements DependentFixtureInterface
{
  /**
   * @param ObjectManager $manager
   * @throws RandomException
   */
  public function load(ObjectManager $manager): void
  {
//    for ($i = 0; $i < 50; $i++) {
//      $book = new Book();
//      $book->setTitle('The Lord of the Rings: Part ' . $i);
//      $book->setShortTitle('LOTR: Part ' . $i);
//      $book->setPublisher($this->getReference("publisher " . $i));
//      $book->setDescription('The sun shines and birds are chirping outside... ' . $i);
//      $book->setOrderNumber(random_int(1000, 9999999));
//      $book->setYear($this->getReference('year ' . $i));
//      $book->setSubject($this->getReference('subject ' . $i));
//      $book->setEbook(true);
//      $book->setEbookPlus(false);
//      $book->setSchoolForm(9999);
//      $book->setBookPrice(50);
//      $book->setGrade($i);
//      $manager->persist($book);
//
//      $this->addReference('book ' . $i, $book);
//    }
//
//    $manager->flush();
  }


  public function getDependencies()
  {
    return [
      PublisherFixture::class,
    ];
  }
}
