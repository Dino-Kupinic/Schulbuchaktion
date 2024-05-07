<?php

namespace App\Controller;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use App\Service\BookOrderService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

/**
 * Controller class for handling book orders.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see BookOrder
 * @see BookOrderRepository
 * @see BookOrderService
 */
#[Route("api/v1/bookOrders")]
class BookOrderController extends AbstractController
{
  #[Route(path: "/", methods: ["GET"])]
  public function getBooks(BookOrderService $bookOrderService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder:read")
      ->toArray();

    try {
      $bookOrders = $bookOrderService->getBookOrders();
      if (count($bookOrders) > 0) {
        return $this->json(["success" => true, "data" => $bookOrders], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get book orders: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/{id}", methods: ["GET"])]
  public function getBook(BookOrderService $bookOrderService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder:read")
      ->toArray();

    try {
      $bookOrders = $bookOrderService->findBookOrderById($id);
      if ($bookOrders == null) {
        return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $bookOrders], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get book order with id $id: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/create", methods: ["POST"])]
  public function createBook(BookOrderService $bookOrderService, Request $request): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder:read")
      ->toArray();

    try {
      $temp = $bookOrderService->parseRequestData($request);
      $bookOrder = $bookOrderService->createBookOrder($temp);
      return $this->json(["success" => true, "data" => $bookOrder], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to create book order: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/delete/{id}", methods: ["DELETE"])]
  public function deleteBook(BookOrderService $bookOrderService, int $id): Response
  {
    try {
      $bookOrderService->deleteBookOrder($id);
      return $this->json(["success" => true, "message" => "Book Order was successfully deleted"], status: Response::HTTP_OK);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to delete book order with id $id: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/update/{id}", methods: ["PUT"])]
  public function updateBook(BookOrderService $bookOrderService, Request $request, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder:read")
      ->toArray();

    try {
      $temp = $bookOrderService->parseRequestData($request);
      $bookOrder = $bookOrderService->updateBookOrder($id, $temp);
      return $this->json(["success" => true, "data" => $bookOrder], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to update book order with id $id: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}


