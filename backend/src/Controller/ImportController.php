<?php

namespace App\Controller;

use App\Entity\AuthToken;
use App\Service\ImportService;
use App\Service\YearService;
use Exception;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("api/v1", name: 'import.'), WithMonologChannel('action')]
class ImportController extends AbstractController
{
  public function __construct(private LoggerInterface $logger)
  {
  }

  #[Route("/importXLSX", name: 'xlsx', methods: "POST")]
  public function index(ImportService $importService, YearService $yearService, Request $request): Response
  {
    $uploadedFile = $request->files->get("file");
    $yearId = $request->request->get("year");

    $token = new AuthToken();
    $token->setJwtString($request->get($_ENV['token_name']));
    $user = $token->getUsername();

    if (!$uploadedFile) {
      $this->logger->error("No file was provided by $user", ['user' => $user]);
      return $this->json(["success" => false, "error" => "No file provided"], Response::HTTP_BAD_REQUEST);
    }

    if (!$yearId) {
      $this->logger->error("No year was provided by $user", ['user' => $user]);
      return $this->json(["success" => false, "error" => "No year provided"], Response::HTTP_BAD_REQUEST);
    }

    $filePath = $uploadedFile->getPathname();
    $data = $importService->parseFile($filePath);

    $header = $data[0];
    if (!$importService->isHeaderValid($header)) {
      $this->logger->error("Invalid XLSX Header was provided by $user", ['user' => $user]);
      return $this->json(["success" => false, "error" => "XLSX Header is invalid, did you provide the correct file?"], Response::HTTP_BAD_REQUEST);
    }

    try {
      $year = $yearService->findYearById($yearId);
      if (!$year) {
        $this->logger->error("Year with id $yearId not find, provided by $user", ['user' => $user]);
        return $this->json(["success" => false, "error" => "Year with id $yearId not found"], Response::HTTP_NOT_FOUND);
      }
      unset($data[0]); // remove header
      $importService->persist($data, $year);
    } catch (Exception $e) {
      $this->logger->error("Failed request from $user", ['user' => $user, 'ex' => $e->getTrace()]);
      return $this->json(["success" => false, "error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    }

    $this->logger->info("File successfully imported which was provided by $user", ['token'=>$token]);
    return $this->json(["success" => true, "data" => []], Response::HTTP_OK);
  }
}
