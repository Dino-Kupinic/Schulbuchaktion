<?php

namespace App\Entity;

use App\Repository\SchoolClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SchoolClassRepository::class)]
class SchoolClass
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?string $name = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?int $grade = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?int $students = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?int $repetents = 0;

  #[ORM\Column]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?int $budget = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?int $usedBudget = null;

  #[ORM\ManyToOne(inversedBy: 'schoolClasses')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?Department $department = null;

  #[ORM\ManyToOne(inversedBy: 'schoolClasses')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups(["schoolClass:read", "bookOrder:read"])]
  private ?Year $year = null;

  #[ORM\OneToMany(targetEntity: BookOrder::class, mappedBy: 'schoolClass')]
  private Collection $bookOrders;


  public function __construct()
  {
    $this->bookOrders = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }


  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }

  public function getGrade(): ?int
  {
    return $this->grade;
  }

  public function setGrade(int $grade): static
  {
    $this->grade = $grade;

    return $this;
  }

  public function getStudents(): ?int
  {
    return $this->students;
  }

  public function setStudents(int $students): static
  {
    $this->students = $students;

    return $this;
  }

  public function getRepetents(): ?int
  {
    return $this->repetents;
  }

  public function setRepetents(?int $repetents): static
  {
    $this->repetents = $repetents;

    return $this;
  }

  public function getBudget(): ?int
  {
    return $this->budget;
  }

  public function setBudget(int $budget): static
  {
    $this->budget = $budget;

    return $this;
  }

  public function getUsedBudget(): ?int
  {
    return $this->usedBudget;
  }

  public function setUsedBudget(int $usedBudget): static
  {
    $this->usedBudget = $usedBudget;

    return $this;
  }

  public function getDepartment(): ?Department
  {
    return $this->department;
  }

  public function setDepartment(?Department $department): static
  {
    $this->department = $department;

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
      $bookOrder->setSchoolClass($this);
    }

    return $this;
  }

  public function removeBookOrder(BookOrder $bookOrder): static
  {
    if ($this->bookOrders->removeElement($bookOrder)) {
      // set the owning side to null (unless already changed)
      if ($bookOrder->getSchoolClass() === $this) {
        $bookOrder->setSchoolClass(null);
      }
    }

    return $this;
  }

  public function getYear(): ?Year
  {
    return $this->year;
  }

  public function setYear(?Year $year): static
  {
    $this->year = $year;

    return $this;
  }

  public function updateFrom(SchoolClass $schoolClass): void
  {
    $this->setName($schoolClass->getName());
    $this->setGrade($schoolClass->getGrade());
    $this->setStudents($schoolClass->getStudents());
    $this->setRepetents($schoolClass->getRepetents());
    $this->setBudget($schoolClass->getBudget());
    $this->setUsedBudget($schoolClass->getUsedBudget());
    $this->setDepartment($schoolClass->getDepartment());
    $this->setYear($schoolClass->getYear());
  }
}
