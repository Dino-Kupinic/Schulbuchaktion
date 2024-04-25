<?php

namespace App\Service;

use PHPUnit\Util\Exception;

class AuthService
{
  public function authenticateUser($user, $password): bool
  {
    $success = null;
    try {
      $ds = ldap_connect($_ENV["LDAP_URL"]) or throw new Exception("Could not connect to LDAP server.");
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
        $userDN = "cn=$user,ou=TestUsers," . $_ENV["LDAP_BASE"];

        $success = @ldap_bind($ds, $userDN, $password) or throw new Exception("Error trying to bind: " . ldap_error($ds));

        ldap_close($ds);
      }
    } catch (Exception $e) {
      $success = false;
    }
    return $success;
  }
}

?>
