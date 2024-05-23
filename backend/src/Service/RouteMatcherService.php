<?php

namespace App\Service;

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
    $parameters = $this->router->match($url);
    return $parameters['_route'];
  }
}
