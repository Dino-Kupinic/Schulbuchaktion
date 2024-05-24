<?php

namespace App\Service;

use App\Entity\AuthToken;
use App\Repository\AuthTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

/**
 * Service class for handling authentication data.
 * @author Michael Ploier
 * @version 1.0
 * @see AuthToken
 * @see AuthTokenRepository
 * @see LoginController
 */
class AuthService
{
  private EntityManagerInterface $em;
  private AuthTokenRepository $authTokenRepository;
  private ParameterBagInterface $parameters;

  /**
   * @param EntityManagerInterface $em
   * @param AuthTokenRepository $authTokenRepository
   * @param ParameterBagInterface $parameters
   */
  public function __construct(EntityManagerInterface $em, AuthTokenRepository $authTokenRepository, ParameterBagInterface $parameters)
  {
    $this->em = $em;
    $this->authTokenRepository = $authTokenRepository;
    $this->parameters = $parameters;
  }


  public function authenticateUser($user, $password): array
  {
    $success = false;
    $role = "SBA_NOT_PERMITTED";
    try {
      $ds = ldap_connect($_ENV["LDAP_URL"]) or throw new Exception("Could not connect to LDAP server.");
      ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
      if ($ds) {
        /**
         * LDAP-Request for school
         *
         * $r = ldap_bind($ds) or throw new Exception("Error trying to bind: " . ldap_error($ds));
         * $sr = ldap_search($ds, $_ENV["SCHULE_BASE"], "cn=$user", array("dn")) or throw new LdapException ("Error in search query: " . ldap_error($ds));
         * $res = ldap_get_entries($ds, $sr);
         * $userDN = $res[0]['dn'];
         */

        /**
         * LDAP-Request for Test-Environment
         */
        $userDN = "cn=$user," . $_ENV["LDAP_BASE"];

        $success = @ldap_bind($ds, $userDN, $password) or throw new Exception("Error trying to bind: " . ldap_error($ds));

        if ($this->checkGroupEx($ds, $userDN, $_ENV["SBA_ADMIN"])) {
          $role = "SBA_ADMIN";
        } else if ($this->checkGroupEx($ds, $userDN, $_ENV["SBA_LEHRER"])) {
          $role = "SBA_LEHRER";
        } else if($this->checkGroupEx($ds, $userDN, $_ENV["SBA_AV"])){
          $role = "SBA_AV";
        } else if($this->checkGroupEx($ds, $userDN, $_ENV["SBA_FV"])){
          $role = "SBA_FV";
        } else {
          $role = "NOT_PERMITTED";
        }

        ldap_close($ds);
      }
    } catch (Exception $e) {
      $success = false;
    }
    return compact('role', 'success');
  }

  public function createToken(string $user, string $password): string
  {
    $status = $this->authenticateUser($user, $password);
    return new AuthToken($user,$status["role"], $status["success"], $this->em);
  }

  public function checkToken(string $JWTString): bool
  {
    $this->optimizeTable();
    try {
      $token = new AuthToken();
      $token->setJwtString($JWTString);
      $dbToken = $this->em->getRepository(AuthToken::class)->find($token->getId());
      if ($token->isValid($dbToken)) {
        $this->updateTime($dbToken);
        return true;
      } else return false;

    } catch (Exception) {
      return false;
    }
  }

  private function updateTime(AuthToken $token): void
  {
    $token->setTimeStamp(time());
    $this->em->persist($token);
    $this->em->flush();

  }

  private function optimizeTable(): void
  {
    $now = time() + 3600 * (int)$_ENV['HOURS_AHEAD'];
    $timeOuteDate = date('c', $now - $_ENV['TOKEN_TIMEOUT']);
    $tokens = $this->authTokenRepository->findExpiredTokens($timeOuteDate);

    foreach ($tokens as $token) {
      $this->em->remove($token);
    }
    $this->em->flush();
  }

  function checkGroupEx($ad, $userdn, $groupdn): bool
  {
    try {
      $attributes = array('gidnumber');
      $result = ldap_read($ad, $userdn, '(objectclass=*)', $attributes);
      if ($result === FALSE) {
        return FALSE;
      };
      $entries = ldap_get_entries($ad, $result);

      if ($entries['count'] <= 0) {
        return FALSE;
      }

      if (empty($entries[0]['gidnumber'])) {
        return FALSE;
      } else {
        for ($i = 0; $i < $entries[0]['gidnumber']['count']; $i++) {
          if ( $entries[0]['gidnumber'][$i] == $groupdn) {
            return TRUE;
          } elseif ($this->checkGroupEx($ad, $entries[0]['gidnumber'][$i], $groupdn)) {
            return TRUE;
          }
        }
      }
      return FALSE;
    } catch (Exception) {
      return false;
    }
  }

  function checkRoutePermission(string $routeName, string $JWTString): bool
  {
    try {
      $path = $this->parameters->get('security_file');
      $xml = simplexml_load_file($path);
      $xmlArray = json_decode(json_encode($xml), true);

      $token = new AuthToken();
      $token->setJwtString($JWTString);

      $routesOfRole = $xmlArray[$token->getRole()]["routes"];
      $pos = strpos($routeName, '.');
      $controller = substr($routeName, 0, $pos);
      $function = substr($routeName, $pos + 1);


      if (array_key_exists($controller, $routesOfRole) && in_array($function, $routesOfRole[$controller]["function"])) {
        return true;
      }
    } catch (Exception){}

    return false;
  }
}


