<?php

/**
 * Utility Class to handle authentication procedures
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XAuthentication {

   /**
    * Returns the userId of the visitor
    *
    * @return mixed Returns the current userId or null on failure
    */
   public static function getUserId() {

      if (isset($_SESSION['id'])) {
         return intval($_SESSION['id']);
      }

      if (isset($_COOKIE['id'])) {
         return intval($_COOKIE['id']);
      }

      return null;
   }


   /**
    * Checks whether the current visiter is authenticated or not
    *
    * @return mixed Return true if visiter is authenticated, false otherwhise
    */
   public static function check() {
      global $xConf;

      $ip = $_SERVER['REMOTE_ADDR'];

      $uId = isset($_COOKIE['id'])  ? $_COOKIE['id']  : null;
      $uId = isset($_SESSION['id']) ? $_SESSION['id'] : $uId;

      $pass = isset($_COOKIE['pass'])  ? $_COOKIE['pass']  : null;
      $pass = isset($_SESSION['pass']) ? $_SESSION['pass'] : $pass;

      $hash = isset($_COOKIE['hash'])  ? $_COOKIE['hash']  : null;
      $hash = isset($_SESSION['hash']) ? $_SESSION['hash'] : $hash;

      $authStr = $ip . $uId . $pass . $xConf->secretKey;
      $candidate = hash($xConf->hashAlgorithm, $authStr);

      return ($candidate == $hash);
   }


   /**
    * Attempts to authenticate the current visitor
    *
    * @param $username The username of the user to authenticate
    * @param $password The password of the user to authenticate
    * @param $cookies Toggles the use of cookies (defaults to false)
    * @return mixed Return true if visitor is authenticated, false otherwhise
    * @throws Exception
    */
   public static function create($username, $password, $cookies = false) {
      global $xDb, $xConf;

      XAuthentication::destroy();
      session_regenerate_id();

      if (!$uId = XAuthentication::_verify($username, $password)) {
      	return self::_snail();
      }

      $password = self::hash($password);
      $ip       = $_SERVER['REMOTE_ADDR'];
      $authStr  = $ip . $uId . $password . $xConf->secretKey;
      $hash     = hash($xConf->hashAlgorithm, $authStr);

      if ($cookies) {

         setcookie("id"   , $uId  , time() + 31536000);
         setcookie("pass" , $password, time() + 31536000);
         setcookie("hash" , $hash , time() + 31536000);

      }

      $_SESSION['id']   = $uId;
      $_SESSION['pass'] = $password;
      $_SESSION['hash'] = $hash;
      self::_snail(true);

      return true;
   }


   /**
    * Slows the process down on multiple failed attempts
    *
    * @param $reset Toggles resetting of the snail counter
    */
   private static function _snail($reset = false) {
      global $xConf;

      if (!array_key_exists('lc', $_SESSION)) {
         $_SESSION['lc'] = 0;
      }

      if ($reset === true) {

      	unset($_SESSION['lc']);
         return null;

      }

      if ($_SESSION['lc'] == $xConf->maxLoginAttempts) {
         return sleep(1);
      }

      $_SESSION['lc']++;
   }


   /**
    * Destroys authentication
    *
    * @return true
    */
   public static function destroy() {

      setcookie("id"  , 0, time() - 3600);
      setcookie("pass", 0, time() - 3600);
      setcookie("hash", 0, time() - 3600);

      unset($_SESSION['id']);
      unset($_SESSION['pass']);
      unset($_SESSION['hash']);

      return true;
   }


   /**
   * Verifies a username / password combination
   *
   * @access protected
   * @param $username String containing the username
   * @param $password String containing the password
   * @return boolean True on success, false on failure
   */
   protected static function _verify($username, $password) {
      global $xConf, $xDb;

      if (!XValidate::isSimpleChars($username)) {
         return false;
      }

      // Database query
      $query = 'SELECT id, yubikey, password, salt  ' .
               'FROM #__users                       ' .
               'WHERE username LIKE BINARY :username';

      // Data retrieval
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':username', $username, PDO::PARAM_STR);
      $stmt->execute();

      if (!$auth = $stmt->fetch(PDO::FETCH_OBJ)) {
         return false;
      }

      // Password verification
      $factors = 0;

      if (self::hash($password, $auth->salt) == $auth->password) {
      	 $factors++;
      }

      // Yubikey verification
      if ($xConf->yUse && $auth->yubikey) {

         if (!$xConf->yApi || !$xConf->yKey) {

            trigger_error('Yubikey details (api, key) missing', E_USER_WARNING);
            return false;

         }

         $yubikey = new Yubikey($xConf->yApi, $xConf->yKey);
         if ($yubikey->verify($password)) {
            $factors++;
         }

      }

      // Verification result
      if (!$factors || $factors < $xConf->loginType + 1) {
         return false;
      }

      return $auth->id;
   }


   /**
    * Generates a random hash based on the given password and salt
    *
    * @param $password The password to use for the hash
    * @param $salt The salt to use for the hash (optional)
    * @return String The generated hash
    */
   public static function hash($password, $salt = null) {

      if (!CRYPT_BLOWFISH) {
         trigger_error('[Core] Blowfish unavailable in crypt().', E_USER_ERROR);
      }

      if (is_null($salt)) {
         $salt = substr(md5(uniqid(rand(), true)), 0, 21);
      }

      return crypt($password, '$2a$08$' . $salt . '$');
   }

}
?>