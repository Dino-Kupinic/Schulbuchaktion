<?php

namespace App\Controller;

use App\Service\YearService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

#[Route("api/v1/years")]
class YearsController extends AbstractController
{
  #[Route(path: "/", methods: ["GET"])]
  public function getYears(YearService $yearsService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("year:read")
      ->toArray();

    try {
      $years = $yearsService->getYears();
      if (count($years) > 0) {
        return $this->json(["success" => true, "data" => $years], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get years: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/{id}", methods: ["GET"])]
  public function getYear(YearService $yearsService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("year:read")
      ->toArray();

    try {
      $year = $yearsService->findYearById($id);
      if ($year == null) {
        return $this->json(["success" => false, "data" => "Year with id $id not found"], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $year], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get year: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/create", methods: ["POST"])]
  public function createYear(YearService $yearsService, Request $request): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("year:read")
      ->toArray();

    try {
      $temp = $yearsService->parseRequestData($request);
      $year = $yearsService->createYear($temp);
      return $this->json(["success" => true, "data" => $year], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to create year: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
