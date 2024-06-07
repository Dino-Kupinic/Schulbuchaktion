<?php

namespace App\Controller;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use App\Service\BookOrderService;
use Exception;
use Monolog\Attribute\WithMonologChannel;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
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

/**
 * @Route("/api/bookOrders")
 */
#[Route("api/v1/bookOrders", name: "bookOrder."), WithMonologChannel('action')]
class BookOrderController extends AbstractController
{
  public function __construct(private LoggerInterface $logger)
  {
  }


  /**
   * @OA\Get(
   *     path="/api/bookOrders",
   *     @OA\Response(
   *         response=200,
   *         description="Returns the list of book orders",
   *         @OA\JsonContent(
   *             type="array",
   *             @OA\Items(ref=@Model(type=BookOrder::class, groups={"read"}))
   *         )
   *     )
   * )
   */
  #[Route(path: "/", name: "index", methods: ["GET"])]
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

  /**
   * @OA\Get(
   *     path="/api/bookOrders/{id}",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the book order",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Returns the book order with the given ID",
   *         @OA\JsonContent(ref=@Model(type=BookOrder::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Book order not found"
   *     )
   * )
   */
  #[Route(path: "/{id}", name: "select", methods: ["GET"])]
  public function getBook(BookOrderService $bookOrderService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder:read")
      ->toArray();

    try {
      $bookOrders = $bookOrderService->findBookOrderById($id);
      if ($bookOrders == null) {
        return $this->json(["success" => false, "data" => "Couldn't find book order with id $id"], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $bookOrders], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get book order with id $id: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Post(
   *     path="/api/bookOrders/create",
   *     @OA\RequestBody(
   *         @OA\JsonContent(ref=@Model(type=BookOrder::class, groups={"write"}))
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Book order created successfully",
   *         @OA\JsonContent(ref=@Model(type=BookOrder::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=500,
   *         description="Failed to create book order"
   *     )
   * )
   */
  #[Route(path: "/create", name: "create", methods: ["POST"])]
  public function createBook(BookOrderService $bookOrderService, Request $request): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder:read")
      ->toArray();

    try {
      $temp = $bookOrderService->parseRequestData($request);
      $bookOrder = $bookOrderService->createBookOrder($temp);
      $this->logger->info("Book order " . $bookOrder->getId() . " successfully created!", ["token" => $request->cookies->get($_ENV['TOKEN_NAME']), 'bookOrderID' => $bookOrder->getId()]);
      return $this->json(["success" => true, "data" => $bookOrder], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      $this->logger->error("Failed to create book order!", $e->getTrace());
      return $this->json([
        "success" => false,
        "error" => "Failed to create book order: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Delete(
   *     path="/api/bookOrders/delete/{id}",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the book order",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Book order deleted successfully"
   *     ),
   *     @OA\Response(
   *         response=500,
   *         description="Failed to delete book order"
   *     )
   * )
   */
  #[Route(path: "/delete/{id}", name: "delete", methods: ["DELETE"])]
  public function deleteBook(BookOrderService $bookOrderService, int $id, Request $request): Response
  {
    try {
      $bookOrder = $bookOrderService->findBookOrderById($id);
      $bookOrderService->deleteBookOrder($id);
      $this->logger->info("Book order successfully deleted!", ["token" => $request->cookies->get($_ENV['TOKEN_NAME']), 'bookOrderID' => $bookOrder->getId()]);
      return $this->json(["success" => true, "message" => "Book Order was successfully deleted"], status: Response::HTTP_OK);
    } catch (Exception $e) {
      $this->logger->error("Failed to delete book order $id!", $e->getTrace());
      return $this->json([
        "success" => false,
        "error" => "Failed to delete book order with id $id: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Put(
   *     path="/api/bookOrders/update/{id}",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the book order",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         @OA\JsonContent(ref=@Model(type=BookOrder::class, groups={"write"}))
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Book order updated successfully",
   *         @OA\JsonContent(ref=@Model(type=BookOrder::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=500,
   *         description="Failed to update book order"
   *     )
   * )
   */
  #[Route(path: "/update/{id}", name: "update", methods: ["PUT"])]
  public function updateBook(BookOrderService $bookOrderService, Request $request, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder:read")
      ->toArray();

    try {
      $temp = $bookOrderService->parseRequestData($request);
      $bookOrder = $bookOrderService->updateBookOrder($id, $temp);
      $this->logger->info("Book order $id successfully updated!", ["token" => $request->cookies->get($_ENV['TOKEN_NAME']), 'bookOrderID' => $bookOrder->getId()]);
      return $this->json(["success" => true, "data" => $bookOrder], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      $this->logger->error("Failed to update book order $id!", $e->getTrace());
      return $this->json([
        "success" => false,
        "error" => "Failed to update book order with id $id: {$e->getMessage()}",
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}


