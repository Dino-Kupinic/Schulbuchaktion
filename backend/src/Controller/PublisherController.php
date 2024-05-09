<?php

namespace App\Controller;

use App\Service\PublisherService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

/**
 * Controller class for handling publishers.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Publisher
 * @see PublisherRepository
 * @see PublisherService
 */
#[Route("api/v1/publishers")]
class PublisherController extends AbstractController
{
  #[Route("/", methods: ["GET"])]
  public function getPublishers(PublisherService $publisherService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("publisher:read")
      ->toArray();

    try {
      $publishers = $publisherService->getPublishers();
      if (count($publishers) > 0) {
        return $this->json(["success" => true, "data" => $publishers], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get publishers: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route("/{id}", methods: ["GET"])]
  public function getPublisher(PublisherService $publisherService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("publisher:read")
      ->toArray();

    try {
      $publisher = $publisherService->findPublisherById($id);
      if ($publisher == null) {
        return $this->json(["success" => false, "error" => "Couldn't find publisher with id $id"], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $publisher], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get publisher: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
