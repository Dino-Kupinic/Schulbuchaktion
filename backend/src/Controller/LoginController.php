<?php

namespace App\Controller;

use App\Entity\AuthToken;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/ldaps', name: 'app_ldap')]
    public function index(AuthService $authService, Request $request): Response
    {
        $user = $request->get("usr");
        $pwd = $request->get("pwd");
        $return = new AuthToken($authService->authenticateUser($user, $pwd));


        return new JsonResponse(json_encode($return), 200, [], true);
    }
}
