<?php

namespace App\Controller;

use App\Entity\Department;
use App\Entity\User;
use App\Repository\DepartmentRepository;
use App\Service\DepartmentService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

/*
 * This controller is either used to get all departments or a department by id
 */

#[Route("/api/v1/departments")]
class DepartmentController extends AbstractController
{
  #[Route(path: "/", methods: ["GET"])]
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
        "error" => "Failed to get departments: " . $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/{id}", methods: ["GET"])]
  public function getDepartment(DepartmentService $departmentService, int $id): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department:read")
      ->toArray();

    try {
      $department = $departmentService->getDepartmentById($id);
      if ($department == null) {
        return $this->json(["success" => true, "data" => []], status: Response::HTTP_NOT_FOUND);
      }
      return $this->json(["success" => true, "data" => $department], status: Response::HTTP_OK, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to get department: " . $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/create", methods: ["POST"])]
  public function createDepartment(Department $department, DepartmentService $departmentService): Response
  {
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department:read")
      ->toArray();

    try {
      $department = $departmentService->createDepartment($department);
      return $this->json(["success" => true, "data" => $department], status: Response::HTTP_CREATED, context: $context);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to create department: " . $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  #[Route(path: "/delete/{id}", methods: ["PUT"])]
  public function deleteDepartment(DepartmentService $departmentService, int $id): Response
  {
    try {
      $departmentService->deleteDepartment($id);
      return $this->json(["success" => true, "message" => "Department was successfully deleted"], status: Response::HTTP_OK);
    } catch (Exception $e) {
      return $this->json([
        "success" => false,
        "error" => "Failed to delete department with id $id: " . $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
