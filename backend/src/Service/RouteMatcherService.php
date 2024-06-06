<?php

namespace App\Service;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class RouteMatcherService
{
  private RouterInterface $router;

  public function __construct(RouterInterface $router)
  {
    $this->router = $router;
  }

  public function getRouteNameFromUrl(string $url): string
  {
    try {
      $parameters = $this->router->match($url);
    } catch (ResourceNotFoundException) {
      $parameters['_route'] = 'null';
    }
    return $parameters['_route'];
  }
}
