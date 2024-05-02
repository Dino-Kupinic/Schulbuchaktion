<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Service\BookService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

#[Route("api/v1")]
class BookController extends AbstractController
{
  /**
   * @return Response -> all books formatted as json
   */
  #[Route(
    path: "/book",
    name: "app_book_get_all",
    methods: ["GET"],
  )]
  public function getBooks(
    BookService $bookService,
    BookRepository $bookRepo
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("book")
      ->toArray();

    //Get all books
    $books = $bookService->getBooks($bookRepo);

    if (count($books) > 0) {
      return $this->json($books, status: Response::HTTP_OK, context: $context);
    }

    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> book formatted as json
   */
  #[Route(
    path: "/book/{id}",
    name: "app_book_get",
    methods: ["GET"],
  )]
  public function getBook(
    BookService $bookService,
    BookRepository $bookRepo,
    int $id
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("book")
      ->toArray();

    //Get the book with the given id
    $book = $bookService->getBookById($id, $bookRepo);

    if (!isEmpty($book)) {
      return $this->json($book, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> book formatted as json
   */
  #[Route(
    path: "/book/create",
    name: "app_book_post",
    methods: ["POST"],
  )]
  public function createBook(
    BookService $bookService,
    EntityManagerInterface $em,
    Book $bookToCreate
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("book")
      ->toArray();

    //Create a new book
    $createdSuccessfully = $bookService->createBook($bookToCreate, $em);

    if ($createdSuccessfully) {
      return $this->json("success", status: Response::HTTP_CREATED, context: $context);
    }

    return $this->json(null, status: Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
