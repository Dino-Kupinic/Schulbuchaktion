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
  #[Groups(["schoolClass:read"])]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Groups(["schoolClass:read"])]
  private ?string $name = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read"])]
  private ?int $grade = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read"])]
  private ?int $students = null;

  #[ORM\Column(nullable: true)]
  #[Groups(["schoolClass:read"])]
  private ?int $repetents = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read"])]
  private ?int $budget = null;

  #[ORM\Column]
  #[Groups(["schoolClass:read"])]
  private ?int $usedBudget = null;

  #[ORM\ManyToOne(inversedBy: 'schoolClasses')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Department $department = null;

  #[ORM\OneToMany(targetEntity: BookOrder::class, mappedBy: 'schoolClass')]
  private Collection $bookOrders;

  #[ORM\ManyToOne(inversedBy: 'schoolClasses')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Years $year = null;

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

  public function getYear(): ?Years
  {
    return $this->year;
  }

  public function setYear(?Years $year): static
  {
    $this->year = $year;

    return $this;
  }
}
