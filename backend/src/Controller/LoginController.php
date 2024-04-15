<?php

namespace App\Controller;

use App\Entity\AuthTokenOld;
use App\Entity\AuthToken;
use App\Kernel;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/ldaps', name: 'app_ldap')]
    public function index(AuthService $authService, Request $request, EntityManagerInterface $em): Response
    {
        $user = $request->get("usr");
        $pwd = $request->get("pwd");

        $token = $authService->createToke($user, $pwd, $em);


        #$token->setValue(['user'=>$user, 'authorized'=>$status]);



        return new JsonResponse($token, 200, [], true);
    }
}
