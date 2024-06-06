<?php

namespace App\Middleware;

use App\Service\AuthService;
use App\Service\RouteMatcherService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class SecurityMiddleware implements EventSubscriberInterface
{
  public function __construct(private AuthService $authService, private RouteMatcherService $routerService)
  {
    $this->authService = $authService;
  }

  public static function getSubscribedEvents()
  {
    return [
      KernelEvents::REQUEST => 'onKernelRequest',
    ];
  }

  public function onKernelRequest(RequestEvent $event): void
  {
    if (strcmp($_ENV['APP_ENV'], 'dev') != 0) {
      $request = $event->getRequest();
      $requestUri = $request->getRequestUri();
      $paramPos = strpos($request->getRequestUri(), '?');
      $requestUri = $paramPos ? substr($requestUri, 0, $paramPos) : $requestUri;


      $parameter = $this->routerService->getRouteNameFromUrl($requestUri);

      if (!(strcmp($requestUri, '/api/v1/login') == 0)) {
        $bearer = $request->cookies->get('bearer');

        if (!$this->authService->checkToken($bearer)) {
          $response = new Response('Token not valid', Response::HTTP_UNAUTHORIZED);
          $event->setResponse($response);
        } else if (!$this->authService->checkRoutePermission($parameter, $bearer)) {
          $response = new Response('Not permitted for this Action', Response::HTTP_UNAUTHORIZED);
          $event->setResponse($response);
        }
      }
    }
  }
}
