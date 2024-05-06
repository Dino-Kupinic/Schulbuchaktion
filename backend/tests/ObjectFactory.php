<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\BookOrder;
use App\Entity\Department;
use App\Entity\Publisher;
use App\Entity\SchoolClass;
use App\Entity\Subject;
use App\Entity\Years;

class ObjectFactory
{
  public static function createYear(): Years
  {
    $year = new Years();
    $year->setYear(2021);
    return $year;
  }

  public static function createSubject(): Subject
  {
    $subject = new Subject();
    $subject->setName('Math');
    return $subject;
  }

  public static function createPublisher(): Publisher
  {
    $publisher = new Publisher();
    $publisher->setPublisherNumber('34');
    $publisher->setName('Springer');
    return $publisher;
  }

  public static function createBook(): Book
  {
    $book = new Book();
    $book->setOrderNumber('123');
    $book->setYear(self::createYear());
    $book->setSubject(self::createSubject());
    $book->setPublisher(self::createPublisher());
    $book->setShortTitle('Mathematics');
    $book->setTitle('Mathematics for beginners');
    $book->setSchoolForm(4100);
    $book->setDescription('This book is for beginners');
    $book->setBookPrice(20.00);
    $book->setEbook(false);
    $book->setEbookPlus(true);
    $book->setGrade('1');
    return $book;
  }

  public static function createDepartment(): Department
  {
    $department = new Department();
    $department->setName('IT');
    $department->setBudget(1000.00);
    $department->setUsedBudget(500.00);
    return $department;
  }

  public static function createSchoolClass(): SchoolClass
  {
    $schoolClass = new SchoolClass();
    $schoolClass->setDepartment(self::createDepartment());
    $schoolClass->setName('1AHITN');
    $schoolClass->setGrade(1);
    $schoolClass->setStudents(20);
    $schoolClass->setRepetents(2);
    $schoolClass->setBudget(100.00);
    $schoolClass->setUsedBudget(50.00);
    $schoolClass->setYear(self::createYear());
    return $schoolClass;
  }

  public static function createBookOrder(): BookOrder
  {
    $bookOrder = new BookOrder();
    $bookOrder->setSchoolClass(self::createSchoolClass());
    $bookOrder->setBook(self::createBook());
    $bookOrder->setYear(self::createYear());
    $bookOrder->setCount(20);
    $bookOrder->setTeacherCopy(true);
    $bookOrder->setLastUser('admin');
    $bookOrder->setCreationUser('admin');
    return $bookOrder;
  }

}
