<?php

namespace App\Controller;

use App\Service\YearService;
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
 * Controller class for handling years.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Year
 * @see YearRepository
 * @see YearService
 */
/**
 * @Route("/api/years")
 */
#[Route("api/v1/years", name: "year."), WithMonologChannel('action')]
class YearController extends AbstractController
{
  public function __construct(private LoggerInterface $logger)
  {
  }

  /**
   * @OA\Get(
   *     path="/api/years",
   *     @OA\Response(
   *         response=200,
   *         description="Returns the list of years",
   *         @OA\JsonContent(
   *             type="array",
   *             @OA\Items(ref=@Model(type=Year::class, groups={"read"}))
   *         )
   *     )
   * )
   */
  #[Route(path: "/", name: "index", methods: ["GET"])]
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
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_OK);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get years: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Get(
   *     path="/api/years/import",
   *     @OA\Response(
   *         response=200,
   *         description="Returns the list of years that can be imported",
   *         @OA\JsonContent(
   *             type="array",
   *             @OA\Items(ref=@Model(type=Year::class, groups={"read"}))
   *         )
   *     )
   * )
   */
  #[Route(path: "/import", name: "import", methods: ["GET"])]
  public function getYearsForImport(YearService $yearsService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("year:read")
      ->toArray();

    try {
      $years = $yearsService->getYearsForImport();
      if (count($years) > 0) {
        return $this->json(["success" => true, "data" => $years], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_OK);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get years: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  /**
   * @OA\Get(
   *     path="/api/years/{id}",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the year",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Returns the year with the given ID",
   *         @OA\JsonContent(ref=@Model(type=Year::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Year with the given ID not found"
   *     )
   * )
   */
  #[Route(path: "/{id}", name: "select", methods: ["GET"])]
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

  /**
   * @OA\Post(
   *     path="/api/years/create",
   *     @OA\RequestBody(
   *         @OA\JsonContent(ref=@Model(type=Year::class, groups={"write"}))
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Year created successfully",
   *         @OA\JsonContent(ref=@Model(type=Year::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=400,
   *         description="Invalid input"
   *     )
   * )
   */
  #[Route(path: "/create", name: "create", methods: ["POST"])]
  public function createYear(YearService $yearsService, Request $request): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("year:read")
      ->toArray();

    try {
      $temp = $yearsService->parseRequestData($request);
      $year = $yearsService->createYear($temp);
      $this->logger->info("Successfully created year ". $year->getId() . "!", ['token'=>$request->cookies->get($_ENV['TOKEN_NAME']), "yearId"=>$year->getId()]);
      return $this->json(["success" => true, "data" => $year], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      $this->logger->info("Failed to create year!", ['token'=>$request->cookies->get($_ENV['TOKEN_NAME']), 'ex'=> $e->getTrace()]);
      return $this->json([
        "success" => false,
        "error" => "Failed to create year: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
