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

/**
 * @Route("/api/departments")
 */
#[Route("/api/v1/departments")]
class DepartmentController extends AbstractController
{

/**
   * @OA\Get(
   *     path="/api/departments",
   *     @OA\Response(
   *         response=200,
   *         description="Returns the list of departments",
   *         @OA\JsonContent(
   *             type="array",
   *             @OA\Items(ref=@Model(type=Department::class, groups={"read"}))
   *         )
   *     )
   * )
   */
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
        "error" => "Failed to get departments: " . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\Get(
   *     path="/api/departments/{id}",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the department",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Returns the department with the given ID",
   *         @OA\JsonContent(ref=@Model(type=Department::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Department not found"
   *     )
   * )
   */
  #[Route(path: "/{id}", methods: ["GET"])]
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

  /**
   * @OA\Post(
   *     path="/api/departments/create",
   *     @OA\RequestBody(
   *         @OA\JsonContent(ref=@Model(type=Department::class, groups={"write"}))
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Department created successfully",
   *         @OA\JsonContent(ref=@Model(type=Department::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=500,
   *         description="Failed to create department"
   *     )
   * )
   */
  #[Route(path: "/create", methods: ["POST"])]
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

  /**
   * @OA\Put(
   *     path="/api/departments/update/{id}",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the department",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         @OA\JsonContent(ref=@Model(type=Department::class, groups={"write"}))
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Department updated successfully",
   *         @OA\JsonContent(ref=@Model(type=Department::class, groups={"read"}))
   *     ),
   *     @OA\Response(
   *         response=500,
   *         description="Failed to update department"
   *     )
   * )
   */
  #[Route(path: "/update/{id}", methods: ["PUT"])]
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
