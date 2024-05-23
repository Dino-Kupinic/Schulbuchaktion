<?php
namespace App\Middleware;

use App\Service\AuthService;
use App\Service\RouteMatcherService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class CustomMiddleware implements EventSubscriberInterface
{

  private AuthService $authService;

  public function __construct(AuthService $authService, private RouteMatcherService $routerService)
  {
    $this->authService = $authService;
  }

  public static function getSubscribedEvents()
  {
    return [
      KernelEvents::REQUEST => 'onKernelRequest',
      KernelEvents::RESPONSE => 'onKernelResponse',
    ];
  }

  public function onKernelRequest(RequestEvent $event): void
  {
    $request = $event->getRequest();
    $requestUri = $request->getRequestUri();
    $paramPos = strpos($request->getRequestUri(), '?');
    $requestUri = $paramPos ? substr($requestUri, 0, $paramPos) : $requestUri;
    var_dump($requestUri);

    $parameter = $this->routerService->getRouteNameFromUrl($requestUri);
    var_dump($parameter);

    if (!(strcmp($requestUri, '/api/v1/login') == 0)) {
      $bearer = $request->cookies->get('bearer');
// Add your logic to handle the request here
// Example: Logging the request URI
// $uri = $request->getUri();
      //error_log('Request URI: ');

      if (!$this->authService->checkToken($bearer)) {
        $response = new Response('Token not valid', Response::HTTP_UNAUTHORIZED);
        $event->setResponse($response);
      }



    }
  }

  public function onKernelResponse(ResponseEvent $event)
  {
    $response = $event->getResponse();
// Add your logic to handle the response here
// Example: Modifying response headers
// $response->headers->set('X-Custom-Header', 'MyCustomHeaderValue');
  }
}
