<?php

namespace App\Controller;

use App\Service\ImportService;
use App\Service\YearService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("api/v1")]
class ImportController extends AbstractController
{
  #[Route("/importXLSX", methods: "POST")]
  public function index(ImportService $importService, YearService $yearService, Request $request): Response
  {
    $uploadedFile = $request->files->get("file");
    $yearId = $request->request->get("year");

    if (!$uploadedFile) {
      return $this->json(["success" => false, "error" => "No file provided"], Response::HTTP_BAD_REQUEST);
    }

    if (!$yearId) {
      return $this->json(["success" => false, "error" => "No year provided"], Response::HTTP_BAD_REQUEST);
    }

    $filePath = $uploadedFile->getPathname();
    $data = $importService->parseFile($filePath);

    $header = $data[0];
    if (!$importService->isHeaderValid($header)) {
      return $this->json(["success" => false, "error" => "XLSX Header is invalid, did you provide the correct file?"], Response::HTTP_BAD_REQUEST);
    }

    try {
      $year = $yearService->findYearById($yearId);
      if (!$year) {
        return $this->json(["success" => false, "error" => "Year with id $yearId not found"], Response::HTTP_NOT_FOUND);
      }
      unset($data[0]); // remove header
      $importService->persist($data, $year);
    } catch (Exception $e) {
      return $this->json(["success" => false, "error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    }


    return $this->json(["success" => true, "data" => []], Response::HTTP_OK);
  }
}
