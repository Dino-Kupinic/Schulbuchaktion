<?php

namespace App\Controller;

use App\Entity\SchoolClass;
use App\Repository\SchoolClassRepository;
use App\Service\SchoolClassService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

#[Route("api/v1")]
class SchoolClassController extends AbstractController
{
  /**
   * @return Response -> all schoolClass formatted as json
   */
  #[Route(
    path: "/schoolClass",
    name: "app_schoolClass_get_all",
    methods: ["GET"],
  )]
  public function getSchoolClasses(
    SchoolClassService $schoolClassService,
    SchoolClassRepository $schoolClassRepo
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass")
      ->toArray();

    //Get all schoolClass
    $schoolClass = $schoolClassService->getSchoolClasses($schoolClassRepo);

    if (count($schoolClass) > 0) {
      return $this->json($schoolClass, status: Response::HTTP_OK, context: $context);
    }

    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> schoolClass formatted as json
   */
  #[Route(
    path: "/schoolClass/{id}",
    name: "app_schoolClass_get",
    methods: ["GET"],
  )]
  public function getSchoolClass(
    SchoolClassService $schoolClassService,
    SchoolClassRepository $schoolClassRepo,
    int $id
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass")
      ->toArray();

    //Get the schoolClass with the given id
    $schoolClass = $schoolClassService->getSchoolClassById($id, $schoolClassRepo);

    if (!isEmpty($schoolClass)) {
      return $this->json($schoolClass, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> schoolClass formatted as json
   */
  #[Route(
    path: "/schoolClass/create",
    name: "app_schoolClass_post",
    methods: ["POST"],
  )]
  public function createSchoolClass(
    SchoolClassService $schoolClassService,
    EntityManagerInterface $em,
    SchoolClass $schoolClassToCreate
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("schoolClass")
      ->toArray();

    //Create a new schoolClass
    $createdSuccessfully = $schoolClassService->createSchoolClass($schoolClassToCreate, $em);

    if ($createdSuccessfully) {
      return $this->json("success", status: Response::HTTP_CREATED, context: $context);
    }

    return $this->json(null, status: Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
