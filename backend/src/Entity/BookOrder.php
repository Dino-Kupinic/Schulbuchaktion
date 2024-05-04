<?php

namespace App\Entity;

use App\Repository\BookOrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookOrderRepository::class)]
class BookOrder
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['book:read'])]
  private ?int $id = null;

  #[ORM\Column]
  #[Groups(['book:read'])]
  private ?int $count = null;

  #[ORM\Column]
  #[Groups(['book:read'])]
  private ?bool $teacherCopy = null;

  #[ORM\Column(length: 255)]
  #[Groups(['book:read'])]
  private ?string $lastUser = null;

  #[ORM\Column(length: 255)]
  #[Groups(['book:read'])]
  private ?string $creationUser = null;

  #[ORM\ManyToOne(inversedBy: 'bookOrders')]
  private ?SchoolClass $schoolClass = null;

  #[ORM\ManyToOne(inversedBy: 'bookOrders')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Book $bookId = null;

  #[ORM\ManyToOne(inversedBy: 'bookOrders')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Years $year = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getCount(): ?int
  {
    return $this->count;
  }

  public function setCount(int $count): static
  {
    $this->count = $count;

    return $this;
  }

  public function isTeacherCopy(): ?bool
  {
    return $this->teacherCopy;
  }

  public function setTeacherCopy(bool $teacherCopy): static
  {
    $this->teacherCopy = $teacherCopy;

    return $this;
  }

  public function getTeacherCopy(): ?bool
  {
    return $this->teacherCopy;
  }

  public function getSchoolClass(): ?SchoolClass
  {
    return $this->schoolClass;
  }

  public function setSchoolClass(?SchoolClass $schoolClass): static
  {
    $this->schoolClass = $schoolClass;

    return $this;
  }

  public function getBookId(): ?Book
  {
    return $this->bookId;
  }

  public function setBookId(?Book $bookId): static
  {
    $this->bookId = $bookId;

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

  public function getLastUser(): ?string
  {
    return $this->lastUser;
  }

  public function setLastUser(string $lastUser): static
  {
    $this->lastUser = $lastUser;

    return $this;
  }

  public function getCreationUser(): ?string
  {
    return $this->creationUser;
  }

  public function setCreationUser(string $creationUser): static
  {
    $this->creationUser = $creationUser;

    return $this;
  }


}
