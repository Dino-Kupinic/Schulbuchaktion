<?php

namespace App\Controller;

use App\Entity\Book;
use App\Service\BookService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

/**
 * Controller class for handling book data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Book
 * @see BookRepository
 * @see BookService
 */
#[Route("api/v1/books")]
class BookController extends AbstractController
{
  #[Route(path: "/", methods: ["GET"])]
  public function getBooks(BookService $bookService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("book:read")
      ->toArray();

    try {
      $books = $bookService->getBooks();
      if (count($books) > 0) {
        return $this->json(["success" => true, "data" => $books], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get books: " . $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/{id}", methods: ["GET"])]
  public function getBook(BookService $bookService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("book:read")
      ->toArray();

    try {
      $book = $bookService->findBookById($id);
      if ($book == null) {
        return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $book], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get book with id $id: {$e->getMessage()}"
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  // TODO: Problem with foreign key constraint
  #[Route(path: "/delete/{id}", methods: ["DELETE"])]
  public function deleteBook(BookService $bookService, int $id): Response
  {
    try {
      $bookService->deleteBook($id);
      return $this->json(["success" => true, "message" => "Book was successfully deleted"], status: Response::HTTP_OK);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to delete book with id $id: {$e->getMessage()}"
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
