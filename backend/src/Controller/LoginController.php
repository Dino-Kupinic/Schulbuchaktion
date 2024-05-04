<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("api/v1")]
class LoginController extends AbstractController
{
  #[Route("/login", name: 'index')]
  public function index(AuthService $authService, Request $request): Response
  {
    $user = $request->get("usr");
    $pwd = $request->get("pwd");

    $token = $authService->createToken($user, $pwd);

    return new JsonResponse(['token' => $token]);
  }
}
