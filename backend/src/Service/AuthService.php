<?php

namespace App\Service;

use App\Entity\AuthToken;
use App\Repository\AuthTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

class AuthService
{
  private EntityManagerInterface $em;
  private AuthTokenRepository $authTokenRepository;

  /**
   * @param EntityManagerInterface $em
   * @param AuthTokenRepository $authTokenRepository
   */
  public function __construct(EntityManagerInterface $em, AuthTokenRepository $authTokenRepository)
  {
    $this->em = $em;
    $this->authTokenRepository = $authTokenRepository;
  }


  public function authenticateUser($user, $password): bool
  {
    $success = false;
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

        ldap_close($ds);
      }
    } catch (Exception) {
      $success = false;
    }
    return $success;
  }

  public function createToken(string $user, string $password): string
  {
    $status = $this->authenticateUser($user, $password);
    return new AuthToken($user, $status, $this->em);
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

    } catch (Exception $e) {
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
}


