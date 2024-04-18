<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
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
    $filePath = $uploadedFile->getPathname();

    $spreadsheet = IOFactory::load($filePath);

    $worksheet = $spreadsheet->getActiveSheet();

    $data = [];
    foreach ($worksheet->getRowIterator() as $row) {
      $rowData = [];
      foreach ($row->getCellIterator() as $cell) {
        $rowData[] = $cell->getValue();
      }
      $data[] = $rowData;
    }

    return $this->json(["success" => true, "data" => $data]);
  }
}
