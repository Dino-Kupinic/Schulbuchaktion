<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents the Book entity
 *
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see BookRepository
 * @see BookService
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?int $id = null;

  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?int $orderNumber = null;

  #[ORM\Column(length: 255, nullable: true)]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?string $shortTitle = null;

  #[ORM\Column(length: 255)]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?string $title = null;

  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?int $schoolForm = null;

  #[ORM\Column(length: 255, nullable: true)]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?string $description = null;

  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?int $bookPrice = null;

  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?bool $ebook = null;

  #[ORM\Column]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?bool $ebookPlus = null;

  #[ORM\Column(length: 255)]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?string $grade = null;

  #[ORM\ManyToOne(inversedBy: 'books')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?Subject $subject = null;

  #[ORM\ManyToOne(inversedBy: 'books')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?Publisher $publisher = null;

  #[ORM\ManyToOne(inversedBy: 'books')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups(['book:read', "bookOrder:read"])]
  private ?Year $year = null;

  #[ORM\OneToMany(targetEntity: BookOrder::class, mappedBy: 'book')]
  private Collection $bookOrders;

  public function __construct()
  {
    $this->bookOrders = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getOrderNumber(): ?int
  {
    return $this->orderNumber;
  }

  public function setOrderNumber(int $orderNumber): static
  {
    $this->orderNumber = $orderNumber;

    return $this;
  }

  public function getShortTitle(): ?string
  {
    return $this->shortTitle;
  }

  public function setShortTitle(string $shortTitle): static
  {
    $this->shortTitle = $shortTitle;

    return $this;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): static
  {
    $this->title = $title;

    return $this;
  }

  public function getSchoolForm(): ?int
  {
    return $this->schoolForm;
  }

  public function setSchoolForm(int $schoolForm): static
  {
    $this->schoolForm = $schoolForm;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): static
  {
    $this->description = $description;

    return $this;
  }

  public function getBookPrice(): ?int
  {
    return $this->bookPrice;
  }

  public function setBookPrice(int $bookPrice): static
  {
    $this->bookPrice = $bookPrice;

    return $this;
  }

  public function isEbook(): ?bool
  {
    return $this->ebook;
  }

  public function setEbook(bool $ebook): static
  {
    $this->ebook = $ebook;

    return $this;
  }

  public function isEbookPlus(): ?bool
  {
    return $this->ebookPlus;
  }

  public function setEbookPlus(bool $ebookPlus): static
  {
    $this->ebookPlus = $ebookPlus;

    return $this;
  }

  public function getSubject(): ?Subject
  {
    return $this->subject;
  }

  public function setSubject(?Subject $subject): static
  {
    $this->subject = $subject;

    return $this;
  }

  public function getPublisher(): ?Publisher
  {
    return $this->publisher;
  }

  public function setPublisher(?Publisher $publisher): static
  {
    $this->publisher = $publisher;

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

  public function getEbook(): ?bool
  {
    return $this->ebook;
  }

  public function getEbookPlus(): ?bool
  {
    return $this->ebookPlus;
  }

  public function setBookOrders(Collection $bookOrders): void
  {
    $this->bookOrders = $bookOrders;
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
      $bookOrder->setBook($this);
    }

    return $this;
  }

  public function removeBookOrder(BookOrder $bookOrder): static
  {
    if ($this->bookOrders->removeElement($bookOrder)) {
      // set the owning side to null (unless already changed)
      if ($bookOrder->getBook() === $this) {
        $bookOrder->setBook(null);
      }
    }

    return $this;
  }

  public function getGrade(): ?string
  {
    return $this->grade;
  }

  public function setGrade(string $grade): static
  {
    $this->grade = $grade;

    return $this;
  }
}
