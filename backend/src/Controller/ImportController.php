<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("api/v1")]
class ImportController extends AbstractController
{
  #[Route('/importXLSX', name: 'app_import')]
  public function index(Request $request): Response
  {
    $uploadedFile = $request->files->get('file');

    if (!$uploadedFile) {
      return new Response('No file uploaded', Response::HTTP_BAD_REQUEST);
    }
    return $this->json(["success" => true, "data" => $uploadedFile]);
  }
}
