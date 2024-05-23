<?php

namespace App\Controller;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use App\Service\SchoolClassService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
#[Route("api/v1/schoolClasses")]
class SchoolClassController extends AbstractController
{

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
  #[Route(path: "/", methods: ["GET"])]
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
        "error" => "Failed to get schoolClasses: " . $e->getMessage()
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
  #[Route(path: "/{id}", methods: ["GET"])]
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
        "error" => "Failed to get schoolClass: " . $e->getMessage()
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
  #[Route(path: "/create", methods: ["POST"])]
  public function createSchoolClass(SchoolClass $schoolClass, SchoolClassService $schoolClassService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass:read")
      ->toArray();

    try {
      $schoolClass = $schoolClassService->createSchoolClass($schoolClass);
      return $this->json(["success" => true, "data" => $schoolClass], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to create schoolClass: " . $e->getMessage()
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
  #[Route(path: "/delete/{id}", methods: ["DELETE"])]
  public function deleteSchoolClass(SchoolClassService $schoolClassService, int $id): Response
  {
    try {
      $schoolClassService->deleteSchoolClass($id);
      return $this->json(["success" => true, "data" => "SchoolClass with id $id deleted"], status: Response::HTTP_OK);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to delete schoolClass: " . $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
