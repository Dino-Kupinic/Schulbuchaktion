<?php

namespace App\Middleware;

use App\Service\AuthService;
use App\Service\RouteMatcherService;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

#[WithMonologChannel('security')]
class SecurityMiddleware implements EventSubscriberInterface
{
  public function __construct(private AuthService $authService, private RouteMatcherService $routerService, private LoggerInterface $logger)
  {}

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
        $bearer = $request->cookies->get($_ENV['TOKEN_NAME']);

        if (!$this->authService->checkToken($bearer)) {
          $this->logger->alert('Token invalid!', ["token"=>$bearer, "ip"=>$request->getClientIp()]);
          $response = new Response('Token not valid', Response::HTTP_UNAUTHORIZED);
          $event->setResponse($response);
        } else if (!$this->authService->checkRoutePermission($parameter, $bearer)) {
          $this->logger->warning('Permission denied!', ["token"=>$bearer, "ip"=>$request->getClientIp(), "route"=>$request->getRequestUri()]);
          $response = new Response('Not permitted for this Action', Response::HTTP_UNAUTHORIZED);
          $event->setResponse($response);
        } else if (str_ends_with($request->getRequestUri(), "/")) {
          $this->logger->alert("Accessing Route: " . $request->getRequestUri(), ["token"=>$bearer, "route"=>"$requestUri"]);
        }
      }
    }
  }
}
