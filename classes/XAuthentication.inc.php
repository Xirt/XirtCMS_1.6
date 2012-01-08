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

      $cId   = isset($_COOKIE['id'])    ? $_COOKIE['id']    : null;
      $cId   = isset($_SESSION['id'])   ? $_SESSION['id']   : $cId;

      $cPass = isset($_COOKIE['pass'])  ? $_COOKIE['pass']  : null;
      $cPass = isset($_SESSION['pass']) ? $_SESSION['pass'] : $cPass;

      $cHash = isset($_COOKIE['hash'])  ? $_COOKIE['hash']  : null;
      $cHash = isset($_SESSION['hash']) ? $_SESSION['hash'] : $cHash;

      $authStr = $cId . $cPass . $xConf->secretKey;
      $gHash = hash($xConf->hashAlgorithm, $authStr);

      return ($gHash == $cHash);
   }


   /**
    * Attempts to authenticate the current visitor
    *
    * @param $uName The username of the user to authenticate
    * @param $uPass The password of the user to authenticate
    * @param $useCookies Toggles the use of cookies (defaults to false)
    * @return mixed Return true if visitor is authenticated, false otherwhise
    * @throws Exception
    */
   public static function create($uName, $uPass, $useCookies = false) {
      global $xDb, $xConf;

      XAuthentication::destroy();

      if (!$uId = XAuthentication::_verify($uName, $uPass)) {
      	return self::_snail();
      }

      $uPass   = hash($xConf->hashAlgorithm, $uPass);
      $authStr = $uId . $uPass . $xConf->secretKey;
      $hash    = hash($xConf->hashAlgorithm, $authStr);

      if ($useCookies) {

         setcookie("id"   , $uId  , time() + 31536000);
         setcookie("pass" , $uPass, time() + 31536000);
         setcookie("hash" , $hash , time() + 31536000);

      }

      $_SESSION['id']   = $uId;
      $_SESSION['pass'] = $uPass;
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
   * @param $uName String containing the username
   * @param $uPass String containing the password
   * @return boolean True on success, false on failure
   */
   protected static function _verify($uName, $uPass) {
      global $xConf, $xDb;

      if (!XValidate::isSimpleChars($uName)) {
         return false;
      }

      $query = "SELECT id, yubikey, password
                FROM #__users
                WHERE username LIKE BINARY '{$uName}'";
      $xDb->setQuery($query);

      if (!$auth = $xDb->loadRow()) {
         return false;
      }

      // Password verification
      $factors = 0;
      if (hash($xConf->hashAlgorithm, $uPass) == $auth->password) {
      	$factors++;
      }

      // Yubikey verification
      if ($xConf->yUse && $auth->yubikey) {

         if (!$xConf->yApi || !$xConf->yKey) {

            trigger_error('Yubikey details (api, key) missing', E_USER_WARNING);
            return false;

         }

         $yubikey = new Yubikey($xConf->yApi, $xConf->yKey);
         if ($yubikey->verify($uPass)) {
            $factors++;
         }

      }

      // Verification result
      if (!$factors || $factors < $xConf->loginType + 1) {
         return false;
      }

      return $auth->id;
   }

}
?>