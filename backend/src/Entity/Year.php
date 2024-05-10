<?php

namespace App\Entity;

use App\Repository\YearsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: YearsRepository::class)]
class Year
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read", "schoolClass:read", "year:read"])]
  private ?int $id = null;

  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read", "schoolClass:read", "year:read"])]
  private ?int $year = null;

  #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'year', orphanRemoval: true)]
  private Collection $books;

  #[ORM\OneToMany(targetEntity: BookOrder::class, mappedBy: 'year', orphanRemoval: true)]
  private Collection $bookOrders;

  #[ORM\OneToMany(targetEntity: SchoolClass::class, mappedBy: 'year', orphanRemoval: true)]
  private Collection $schoolClasses;

  public function __construct()
  {
    $this->books = new ArrayCollection();
    $this->bookOrders = new ArrayCollection();
    $this->schoolClasses = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getYear(): ?int
  {
    return $this->year;
  }

  public function setYear(int $year): static
  {
    $this->year = $year;

    return $this;
  }

  /**
   * @return Collection<int, Book>
   */
  public function getBooks(): Collection
  {
    return $this->books;
  }

  public function addBook(Book $book): static
  {
    if (!$this->books->contains($book)) {
      $this->books->add($book);
      $book->setYear($this);
    }

    return $this;
  }

  public function removeBook(Book $book): static
  {
    if ($this->books->removeElement($book)) {
      $book->removeYear();
    }

    return $this;
  }

  /**
   * @return Collection<int, BookOrder>
   */
  public function getBookOrders(): Collection
  {
    return $this->bookOrders;
  }

  public function addBookOrder(BookOrder $bookOrder): static
  {
    if (!$this->bookOrders->contains($bookOrder)) {
      $this->bookOrders->add($bookOrder);
      $bookOrder->setYear($this);
    }

    return $this;
  }

  public function removeBookOrder(BookOrder $bookOrder): static
  {
    if ($this->bookOrders->removeElement($bookOrder)) {
      // set the owning side to null (unless already changed)
      if ($bookOrder->getYear() === $this) {
        $bookOrder->setYear(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, SchoolClass>
   */
  public function getSchoolClasses(): Collection
  {
    return $this->schoolClasses;
  }

  public function addSchoolClass(SchoolClass $schoolClass): static
  {
    if (!$this->schoolClasses->contains($schoolClass)) {
      $this->schoolClasses->add($schoolClass);
      $schoolClass->setYear($this);
    }

    return $this;
  }

  public function removeSchoolClass(SchoolClass $schoolClass): static
  {
    if ($this->schoolClasses->removeElement($schoolClass)) {
      // set the owning side to null (unless already changed)
      if ($schoolClass->getYear() === $this) {
        $schoolClass->setYear(null);
      }
    }

    return $this;
  }

  public function updateFrom(Year $year)
  {
    $this->setYear($year->getYear());
  }
}
