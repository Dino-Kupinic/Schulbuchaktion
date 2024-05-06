<?php

namespace App\Controller;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use App\Service\SchoolClassService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;


/**
 * Controller class for handling schoolClass data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see SchoolClass
 * @see SchoolClassRepository
 * @see SchoolClassService
 */
#[Route("api/v1/schoolClass")]
class SchoolClassController extends AbstractController
{
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

  #[Route(path: "/{id}", methods: ["GET"])]
  public function getSchoolClass(SchoolClassService $schoolClassService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass:read")
      ->toArray();

    try {
      $schoolClass = $schoolClassService->findSchoolClassById($id);
      if ($schoolClass == null) {
        return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $schoolClass], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get schoolClass: " . $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

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
