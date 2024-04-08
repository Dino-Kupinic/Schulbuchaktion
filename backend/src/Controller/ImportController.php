<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("api/v1")]
class ImportController extends AbstractController
{
  #[Route('/importXLSX', name: 'app_import')]
  public function index(): Response
  {

    return $this->render('import/index.html.twig', [
      'controller_name' => 'ImportController',
    ]);
  }
}
