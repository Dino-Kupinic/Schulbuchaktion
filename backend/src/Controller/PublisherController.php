<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use App\Service\PublisherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

#[Route("api/v1")]
class PublisherController extends AbstractController
{
  /**
   * @return Response -> all publishers formatted as json
   */
  #[Route(
    path: "/publisher",
    name: "app_publisher_get_all",
    methods: ["GET"],
  )]
  public function getPublishers(
    PublisherService $publisherService,
    PublisherRepository $publisherRepo
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("publisher")
      ->toArray();

    //Get all publishers
    $publishers = $publisherService->getPublishers($publisherRepo);

    if (count($publishers) > 0) {
      return $this->json($publishers, status: Response::HTTP_OK, context: $context);
    }

    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> publisher formatted as json
   */
  #[Route(
    path: "/publisher/{id}",
    name: "app_publisher_get",
    methods: ["GET"],
  )]
  public function getPublisher(
    PublisherService $publisherService,
    PublisherRepository $publisherRepo,
    int $id
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("publisher")
      ->toArray();

    //Get the publisher with the given id
    $publisher = $publisherService->getPublisherById($id, $publisherRepo);

    if (!isEmpty($publisher)) {
      return $this->json($publisher, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> publisher formatted as json
   */
  #[Route(
    path: "/create/publisher",
    name: "app_publisher_post",
    methods: ["POST"],
  )]
  public function createPublisher(
    PublisherService $publisherService,
    EntityManagerInterface $em,
    Publisher $publisherToCreate
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("publisher")
      ->toArray();

    //Create a new publisher
    $createdSuccessfully = $publisherService->createPublisher($publisherToCreate, $em);

    if ($createdSuccessfully) {
      return $this->json("success", status: Response::HTTP_CREATED, context: $context);
    }

    return $this->json(null, status: Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
