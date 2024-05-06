<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(["department:read", "bookOrder:read"])]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Groups(["department:read", "bookOrder:read"])]
  private ?string $name = null;

  #[ORM\Column]
  #[Groups(["department:read", "bookOrder:read"])]
  private ?int $budget = null;

  #[ORM\Column]
  #[Groups(["department:read", "bookOrder:read"])]
  private ?int $usedBudget = null;

  #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
  #[Groups(["department:read", "bookOrder:read"])]
  private ?DateTimeInterface $validFrom = null;

  #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
  #[Groups(["department:read", "bookOrder:read"])]
  private ?DateTimeInterface $validTo = null;

  #[ORM\OneToMany(targetEntity: SchoolClass::class, mappedBy: 'department')]
  private Collection $schoolClasses;

  public function __construct()
  {
    $this->schoolClasses = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(int $id): static
  {
    $this->id = $id;

    return $this;
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
      $schoolClass->setDepartment($this);
    }

    return $this;
  }

  public function removeSchoolClass(SchoolClass $schoolClass): static
  {
    if ($this->schoolClasses->removeElement($schoolClass)) {
      // set the owning side to null (unless already changed)
      if ($schoolClass->getDepartment() === $this) {
        $schoolClass->setDepartment(null);
      }
    }

    return $this;
  }

  public function updateFrom(Department $department): void
  {
    $this->setName($department->getName());
    $this->setBudget($department->getBudget());
    $this->setUsedBudget($department->getUsedBudget());
    $this->setValidFrom($department->getValidFrom());
    $this->setValidTo($department->getValidTo());
  }

  public function getValidFrom(): ?\DateTimeInterface
  {
    return $this->validFrom;
  }

  public function setValidFrom(?\DateTimeInterface $validFrom): static
  {
    $this->validFrom = $validFrom;

    return $this;
  }

  public function getValidTo(): ?\DateTimeInterface
  {
    return $this->validTo;
  }

  public function setValidTo(?\DateTimeInterface $validTo): static
  {
    $this->validTo = $validTo;

    return $this;
  }
}
