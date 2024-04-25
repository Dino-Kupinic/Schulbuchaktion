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

class LoginController extends AbstractController
{
  #[Route('/ldaps', name: 'app_ldap')]
  public function index(AuthService $authService, Request $request, EntityManagerInterface $em, AuthTokenRepository $repo): Response
  {
    $user = $request->get("usr");
    $pwd = $request->get("pwd");
    $test = $request->get("tk", '');

    //$token = $authService->createToken($user, $pwd);
    try {
      $token = $authService->checkToken($test);
      if (!$token) {
        return new JsonResponse(["isValid" => false]);
      }
    } catch (Exception) {
      return new JsonResponse(["isValid" => false]);
    }

    #$token->setValue(['user'=>$user, 'authorized'=>$status]);
    //$authService->optimizeTable();


    return new JsonResponse(['isValid' => $token]);
  }
}
