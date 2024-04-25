<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestingController extends AbstractController
{
  #[Route('/test/example', name: 'app_testing')]
  public function index(): Response
  {
    return $this->json(['name' => 'John']);
  }
}
