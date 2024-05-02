<?php

namespace App\Controller;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use App\Service\BookOrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

#[Route("api/v1")]
class BookOrderController extends AbstractController
{
  /**
   * @return Response -> all bookOrders formatted as json
   */
  #[Route(
    path: "/bookOrder",
    name: "app_bookOrder_get_all",
    methods: ["GET"],
  )]
  public function getBookOrders(
    bookOrderService $bookOrderService,
    bookOrderRepository $bookOrderRepo
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder")
      ->toArray();

    //Get all bookOrders
    $bookOrders = $bookOrderService->getbookOrders($bookOrderRepo);

    if (count($bookOrders) > 0) {
      return $this->json($bookOrders, status: Response::HTTP_OK, context: $context);
    }

    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> bookOrder formatted as json
   */
  #[Route(
    path: "/bookOrder/{id}",
    name: "app_bookOrder_get",
    methods: ["GET"],
  )]
  public function getBookOrder(
    bookOrderService $bookOrderService,
    bookOrderRepository $bookOrderRepo,
    int $id
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder")
      ->toArray();

    //Get the bookOrder with the given id
    $bookOrder = $bookOrderService->getbookOrderById($id, $bookOrderRepo);

    if (!isEmpty($bookOrder)) {
      return $this->json($bookOrder, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> bookOrder formatted as json
   */
  #[Route(
    path: "/bookOrder/create",
    name: "app_bookOrder_post",
    methods: ["POST"],
  )]
  public function createBookOrder(
    bookOrderService $bookOrderService,
    EntityManagerInterface $em,
    bookOrder $bookOrderToCreate
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("bookOrder")
      ->toArray();

    //Create a new bookOrder
    $createdSuccessfully = $bookOrderService->createbookOrder($bookOrderToCreate, $em);

    if ($createdSuccessfully) {
      return $this->json("success", status: Response::HTTP_CREATED, context: $context);
    }

    return $this->json(null, status: Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}

