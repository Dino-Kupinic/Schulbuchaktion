<?php

namespace App\Controller;

use App\Entity\Years;
use App\Repository\YearsRepository;
use App\Service\YearsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

#[Route("api/v1")]
class YearsController extends AbstractController
{
  /**
   * @return Response -> all years formatted as json
   */
  #[Route(
    path: "/years",
    name: "app_years_get_all",
    methods: ["GET"],
  )]
  public function getYears(
    YearsService $yearsService,
    YearsRepository $yearsRepo
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("years")
      ->toArray();

    //Get all years
    $years = $yearsService->getYears($yearsRepo);

    if (count($years) > 0) {
      return $this->json($years, status: Response::HTTP_OK, context: $context);
    }

    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> years formatted as json
   */
  #[Route(
    path: "/years/{id}",
    name: "app_years_get",
    methods: ["GET"],
  )]
  public function getYear(
    YearsService $yearsService,
    YearsRepository $yearsRepo,
    int $id
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("years")
      ->toArray();

    //Get the years with the given id
    $years = $yearsService->getYearsById($id, $yearsRepo);

    if (!isEmpty($years)) {
      return $this->json($years, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> years formatted as json
   */
  #[Route(
    path: "/create/years",
    name: "app_years_post",
    methods: ["POST"],
  )]
  public function createYear(
    YearsService $yearsService,
    EntityManagerInterface $em,
    Years $yearsToCreate
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("years")
      ->toArray();

    //Create a new years
    $createdSuccessfully = $yearsService->createYear($yearsToCreate, $em);

    if ($createdSuccessfully) {
      return $this->json("success", status: Response::HTTP_CREATED, context: $context);
    }

    return $this->json(null, status: Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
