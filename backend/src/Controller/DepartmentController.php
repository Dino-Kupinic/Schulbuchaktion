<?php

namespace App\Controller;

use App\Entity\Department;
use App\Entity\User;
use App\Repository\DepartmentRepository;
use App\Service\DepartmentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use function PHPUnit\Framework\isEmpty;

/*
 * This controller is either used to get all departments or a department by id
 */

#[Route("/api/v1")]
class DepartmentController extends AbstractController {
  /**
   * @return Response -> all departments formatted as json
   */
  #[Route(
    path: "/department",
    name: "app_department",
    methods: ["GET"]
  )]
  public function getDepartments(
    DepartmentRepository $departmentRepo,
    DepartmentService $departmentService,
  ): Response {
    //Get the current user


    //Check if the user is logged in


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department")
      ->toArray();

    //Get all departments
    $departments = $departmentService->getDepartments($departmentRepo);

    if (count($departments) > 0) {
      return $this->json($departments, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> the department with the given id formatted as json
   */
  #[Route(
    path: "/department/{id}",
    name: "app_department_get_by_id",
    methods: ["GET"]
  )]
  public function getDepartmentById(
    DepartmentRepository $departmentRepo,
    DepartmentService $departmentService,
    int $id
  ):Response {
    //Get the current user

    //Check if the user is logged in


    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department")
      ->toArray();

    //Search for a department in the repository with the value of the given id parameter
    $department = $departmentService->getDepartmentById($id, $departmentRepo);

    if (!isEmpty($department)) {
      return $this->json($department, status: Response::HTTP_OK, context: $context);
    }
    return $this->json(null, status: Response::HTTP_NOT_FOUND);
  }


  /**
   * @return Response -> the department with the given id formatted as json
   */
  #[Route(
    path: "/department/create",
    name: "app_department_create",
    methods: ["POST"]
  )]
  public function createDepartment(
    EntityManagerInterface $em,
    DepartmentService $departmentService,
    Department $department,
  ): Response {
    //Get the current user

    //Check if the user is logged in

    //Save the groups of which the content should be returned in the $context variable
    $context = (new ObjectNormalizerContextBuilder())
      ->withGroups("department")
      ->toArray();

    $createdSuccessfully = $departmentService->createDepartment($department, $em);

    if ($createdSuccessfully) {
      return $this->json('success', status: Response::HTTP_CREATED, context: $context);
    }
    return $this->json(null, status: Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
