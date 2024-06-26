<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read", "subject:read"])]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Groups(['book:read', "bookOrder:read", "subject:read"])]
  private ?string $name = null;

  #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'subject', cascade: ['persist'])]
  private Collection $books;

  public function __construct()
  {
    $this->books = new ArrayCollection();
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
      $book->setSubject($this);
    }

    return $this;
  }

  public function removeBook(Book $book): static
  {
    if ($this->books->removeElement($book)) {
      // set the owning side to null (unless already changed)
      if ($book->getSubject() === $this) {
        $book->setSubject(null);
      }
    }

    return $this;
  }
}
