<?php

namespace App\Command;

use DOMDocument;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

#[AsCommand(name: 'security:create-xml', description: 'Creates security.xml for permission handling')]
class CreateSecurityXML extends Command
{
  public function __construct(private RouterInterface $router, private ParameterBagInterface $parameters, ?string $name = null)
  {
    parent::__construct($name);
  }


  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $fileSystem = new Filesystem();
    try {

      $routes = $this->router->getRouteCollection();
      $xml = $this->generateXml($routes);
      $filePath = $this->parameters->get('security_path') . '/security.generated.xml';
      $fileSystem->dumpFile($filePath, $xml);
      $io->success('Security file created successfully in ' . $filePath);
      $io->warning('Now you have to rename or copy the generated file to "security.xml" in the same path!');
      $io->caution('Be aware of the fact, that this file contains all rights for all roles.' . "\n" . 'You have to delete controller or function tags to deny access for specific roles!');
      return Command::SUCCESS;
    } catch (Exception $e) {
      $io->error($e->getMessage());
      return Command::FAILURE;
    }
  }

  public function generateXml(RouteCollection $routes): string
  {
    $dom = new DOMDocument('1.0', 'UTF-8');

    $root = $dom->createElement('groups');
    $dom->appendChild($root);
    $allController = [];
    $roles = explode(',', $_ENV["ROLES"]);

    foreach ($routes as $name => $route) {
      if (str_contains($name, '.')) {
        $pos = strpos($name, '.');
        $controller = substr($name, 0, $pos);
        $function = substr($name, $pos + 1);
        $allController[$controller][] = $function;
      }
    }

    $routesTag = $dom->createElement('routes');
    foreach ($allController as $index => $controller) {
      $controllerTag = $dom->createElement($index);
      foreach ($controller as $function) {
        $controllerTag->appendChild($dom->createElement('function', $function));
      }
      $routesTag->appendChild($controllerTag);
    }

    foreach ($roles as $role) {
      $roleTag = $dom->createElement($role);
      $roleTag->appendChild($routesTag->cloneNode(true));
      $root->appendChild($roleTag);
    }

    // Set formatOutput to true for pretty printing
    $dom->formatOutput = true;

    // Return the XML string as a response
    return $dom->saveXML();
  }

}
