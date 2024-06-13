<?php

namespace App\Controller;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use App\Service\SchoolClassService;
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
 * Controller class for handling schoolClass data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see SchoolClass
 * @see SchoolClassRepository
 * @see SchoolClassService
 */

/**
 * @Route("/api/schoolClasses")
 */
#[Route("api/v1/schoolClasses", name: "schoolClass."), WithMonologChannel('action')]
class SchoolClassController extends AbstractController
{
  public function __construct(private LoggerInterface $logger)
  {
  }

  /**
   * @OA\Get(
   *     path="/api/schoolClasses",
   *     @OA\Response(
   *         response=200,
   *         description="Returns the list of schoolClasses",
   *         @OA\JsonContent(
   *             type="array",
   *             @OA\Items(ref=@Model(type=SchoolClass::class, groups={"read"}))
   *         )
   *     )
   * )
   */
  #[Route(path: "/", name: "index", methods: ["GET"])]
  public function getSchoolClasses(SchoolClassService $schoolClassService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass:read")
      ->toArray();

    try {
      $schoolClasses = $schoolClassService->getSchoolClasses();
      if (count($schoolClasses) > 0) {
        return $this->json(["success" => true, "data" => $schoolClasses], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get schoolClasses: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Get(
   *     path="/api/schoolClasses/{id}",
   *     @OA\Response(
   *         response=200,
   *         description="Returns the schoolClass with the given id",
   *         @OA\JsonContent(ref=@Model(type=SchoolClass::class, groups={"read"}))
   *     )
   * )
   */
  #[Route(path: "/{id}", name: "select", methods: ["GET"])]
  public function getSchoolClass(SchoolClassService $schoolClassService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass:read")
      ->toArray();

    try {
      $schoolClass = $schoolClassService->findSchoolClassById($id);
      if ($schoolClass == null) {
        return $this->json(["success" => false, "error" => "Couldn't find school class with id $id"], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $schoolClass], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get schoolClass: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Post(
   *     path="/api/schoolClasses/create",
   *     @OA\Response(
   *         response=201,
   *         description="Creates a new schoolClass",
   *         @OA\JsonContent(ref=@Model(type=SchoolClass::class, groups={"read"}))
   *     )
   * )
   */
  #[Route(path: "/create", name: "create", methods: ["POST"])]
  public function createSchoolClass(SchoolClassService $schoolClassService, Request $request): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass:read")
      ->toArray();

    try {
      $temp = $schoolClassService->parseRequestData($request);
      $schoolClass = $schoolClassService->createSchoolClass($temp);
      $this->logger->info("Successfully created school class " . $schoolClass->getId() . "!", ['token' => $request->cookies->get($_ENV['TOKEN_NAME']), 'schoolClassId' => $schoolClass->getId()]);
      return $this->json(["success" => true, "data" => $schoolClass], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      $this->logger->error("Failed to create school class!", ['token' => $request->cookies->get($_ENV['TOKEN_NAME'],), 'ex' => $e->getTrace()]);
      return $this->json([
        "success" => false,
        "error" => "Failed to create schoolClass: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Put(
   *     path="/api/schoolClasses/update/{id}",
   *     @OA\Response(
   *         response=200,
   *         description="Updates the schoolClass with the given id",
   *         @OA\JsonContent(ref=@Model(type=SchoolClass::class, groups={"read"}))
   *     )
   * )
   */
  #[Route(path: "/delete/{id}", name: "delete", methods: ["DELETE"])]
  public function deleteSchoolClass(SchoolClassService $schoolClassService, int $id, Request $request): Response
  {
    try {
      $schoolClassService->deleteSchoolClass($id);
      $this->logger->info("Successfully deleted school class $id!", ['token' => $request->cookies->get($_ENV['TOKEN_NAME']), 'schoolClassId' => $id]);
      return $this->json(["success" => true, "data" => "SchoolClass with id $id deleted"], status: Response::HTTP_OK);
    } catch (Exception $e) {
      $this->logger->error("Failed to delete school class $id!", ['token' => $request->cookies->get($_ENV['TOKEN_NAME']), 'ex' => $e->getTrace()]);
      return $this->json([
        "success" => false,
        "error" => "Failed to delete schoolClass: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
