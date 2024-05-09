<?php

namespace App\Controller;

use App\Service\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("api/v1")]
class ImportController extends AbstractController
{
  #[Route("/importXLSX", name: "app_import", methods: "POST")]
  public function index(ImportService $importService, Request $request): Response
  {
    $uploadedFile = $request->files->get("file");

    if (!$uploadedFile) {
      return new Response("No file provided", Response::HTTP_BAD_REQUEST);
    }

    $filePath = $uploadedFile->getPathname();
    $data = $importService->parseFile($filePath);

    $header = $data[0];
    if ($importService->isHeaderValid($header)) {
      unset($data[0]);
      $importService->persist($data);
//      return new Response("Success", Response::HTTP_OK);
      return $this->json($data, Response::HTTP_OK);
    }

    return new Response(
      "XLSX Header is invalid, did you provide the correct file?",
      Response::HTTP_BAD_REQUEST
    );
  }
}
