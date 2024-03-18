<?php

namespace App\Controller;

use Exception;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Ldap\Exception\LdapException;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class LoginController extends AbstractController
{
    #[Route('/ldaps', name: 'app_ldap')]
    public function index(Request $request): Response
    {
        $user = $request->get("usr");
        $pwd = $request->get("pwd");
        try {
            $success = $this->authenticateUser($user, $pwd);
        } catch (LdapException | Exception $e) {
            $success = false;
        }
        $success = ($success) ? "true" : "false";


        return $this->render('ldap/index.html.twig', [
            "info"=> [$success]
        ]);
    }

    private function authenticateUser($user, $password): bool
    {
        $ds = ldap_connect($_ENV["LDAP_URL"]) or throw new LdapException("Could not connect to LDAP server.");
        if ($ds) {
            $r = ldap_bind($ds) or die ("Error trying to bind: " . ldap_error($ds));

            // Search the users dn as anonymous
            $sr = ldap_search($ds, $_ENV["LDAP_BASE"], "cn=" . $user, array("dn")) or throw new LdapException ("Error in search query: " . ldap_error($ds));
            $res = ldap_get_entries($ds, $sr);
            $userDN = $res[0]['dn'];
            $r = ldap_bind($ds, $userDN, $password) or throw new LdapException("Error trying to bind: " . ldap_error($ds));
        }
        return true;
    }
}
