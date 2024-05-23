<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use App\Service\SubjectService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

/**
 * Controller class for handling subject data.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Subject
 * @see SubjectRepository
 * @see SubjectService
 */
#[Route("api/v1/subjects", name: "subject.")]
class SubjectController extends AbstractController
{
  #[Route(path: "/", name: "index", methods: ["GET"])]
  public function getSubjects(SubjectService $subjectService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("subject:read")
      ->toArray();

    try {
      $subjects = $subjectService->getSubjects();
      if (count($subjects) > 0) {
        return $this->json(["success" => true, "data" => $subjects], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get subjects: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/{id}", name: "index", methods: ["GET"])]
  public function getSubject(SubjectService $subjectService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("subject:read")
      ->toArray();

    try {
      $subject = $subjectService->findSubjectById($id);
      if ($subject == null) {
        return $this->json(["success" => false, "data" => "Subject with id $id not found"], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $subject], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get subject: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
