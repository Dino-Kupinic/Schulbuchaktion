<?php

namespace App\Controller;

use App\Repository\AuthTokenRepository;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/login', name: 'login.')]
class LoginController extends AbstractController
{
  #[Route(name: 'index')]
  public function index(AuthService $authService, Request $request): Response
  {
    $user = $request->get("usr");
    $pwd = $request->get("pwd");

    $token = $authService->createToken($user, $pwd);

    #$token->setValue(['user'=>$user, 'authorized'=>$status]);
    //$authService->optimizeTable();


    return new JsonResponse(['token' => $token]);
  }
}
