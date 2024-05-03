<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use App\Service\SubjectService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

#[Route("api/v1")]
class SubjectController extends AbstractController
{
  /**
   * @return Response -> all subjects formatted as json
   */
  #[Route(
    path: "/subject",
    name: "app_subject_get_all",
    methods: ["GET"],
  )]
  public function getSubjects(
    SubjectService $subjectService,
    SubjectRepository $subjectRepo
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("subject")
      ->toArray();

    //Get all subjects
    $subjects = $subjectService->getSubjects($subjectRepo);

    if (count($subjects) > 0) {
      return $this->json($subjects, status: Response::HTTP_OK, context: $context);
    }

    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> subject formatted as json
   */
  #[Route(
    path: "/subject/{id}",
    name: "app_subject_get",
    methods: ["GET"],
  )]
  public function getSubject(
    SubjectService $subjectService,
    SubjectRepository $subjectRepo,
    int $id
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("subject")
      ->toArray();

    //Get the subject with the given id
    $subject = $subjectService->getSubjectById($id, $subjectRepo);

    if (!isEmpty($subject)) {
      return $this->json($subject, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> subject formatted as json
   */
  #[Route(
    path: "/subject/create",
    name: "app_subject_post",
    methods: ["POST"],
  )]
  public function createSubject(
    SubjectService $subjectService,
    EntityManagerInterface $em,
    Subject $subjectToCreate
  ): Response {
    //Get the current user


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("subject")
      ->toArray();

    //Create a new subject
    $createdSuccessfully = $subjectService->createSubject($subjectToCreate, $em);

    if ($createdSuccessfully) {
      return $this->json("success", status: Response::HTTP_CREATED, context: $context);
    }

    return $this->json(null, status: Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
