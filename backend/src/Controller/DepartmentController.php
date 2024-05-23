<?php

namespace App\Controller;

use App\Entity\Department;
use App\Service\DepartmentService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

/**
 * Controller class for handling book orders.
 * @author Lukas Bauer, Dino Kupinic
 * @version 1.0
 * @see Department
 * @see DepartmentService
 * @see DepartmentRepository
 */
#[Route("/api/v1/departments", name: "department.")]
class DepartmentController extends AbstractController
{
  #[Route(path: "/", name: "index", methods: ["GET"])]
  public function getDepartments(DepartmentService $departmentService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department:read")
      ->toArray();

    try {
      $departments = $departmentService->getDepartments();
      if (count($departments) > 0) {
        return $this->json(["success" => true, "data" => $departments], status: Response::HTTP_OK, context: $context);
      }
      return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get departments: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/{id}", name: "index", methods: ["GET"])]
  public function getDepartment(DepartmentService $departmentService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department:read")
      ->toArray();

    try {
      $department = $departmentService->findDepartmentById($id);
      if ($department == null) {
        return $this->json(["success" => false, "data" => "Couldn't find department with id $id"], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $department], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get department with id $id: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/create", name: "create", methods: ["POST"])]
  public function createDepartment(DepartmentService $departmentService, Request $request): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department:read")
      ->toArray();

    try {
      $temp = $departmentService->parseRequestData($request);
      $department = $departmentService->createDepartment($temp);
      return $this->json(["success" => true, "data" => $department], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to create department: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/update/{id}", name: "update", methods: ["PUT"])]
  public function updateDepartment(DepartmentService $departmentService, Request $request, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department:read")
      ->toArray();

    try {
      $temp = $departmentService->parseRequestData($request);
      $department = $departmentService->updateDepartment($id, $temp);
      return $this->json(["success" => true, "data" => $department], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to update department: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
