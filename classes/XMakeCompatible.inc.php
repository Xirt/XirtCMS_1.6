<?php

/**
 * Utility Class to ensure compatiblity with various environments
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XMakeCompatible {

   /**
    * Prevents caching of website in browser
    */
   public static function noCache() {

      session_cache_limiter('nocache');
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Expires: Sun, 15 Jun 1986 00:00:00 GMT");
      header("Pragma: no-cache");

   }


   /**
    * Decodes a SEF URL into a regular page query
    */
   public static function prepareLink() {
      global $xConf;

      if (defined('_ADMIN') || !$xConf->sefUrls) {
         return false;
      }

      if (!$path = parse_url($xConf->baseURL, PHP_URL_PATH)) {
         trigger_error("Malformed 'baseURL' found in config.", E_USER_ERROR);
      }

      // Retrieve original URL
      $uri = $_SERVER['REQUEST_URI'];
      if (strpos($uri, $path) === 0) {
         $uri = substr($uri, strlen($path));
      }

      // Create XLink with URL
      $link = new XLink(null, null, null, $uri);

      // Parse URL if necessary
      if ($link->uri_ori && $link->iso) {

         parse_str($link->uri_ori, $args);
         $xConf->setLanguage($link->iso);
         $_GET = array_merge($_GET, $args);

         if (!array_key_exists('cid', $_GET)) {
            $_GET['cid'] = $link->cid;
         }

      }

   }


   /**
    * Ensures compatibility with MAGIC_QUOTES_GPC / MAGIC_QUOTES_SYBASE
    */
   public static function prepareArguments() {

      if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
         $isEscaped = true;
      }

      if (strtolower(ini_get('magic_quotes_sybase')) == 'on') {
         $isEscaped = true;
      }

      if (isset($escaped)) {

         $in = array(&$_GET, &$_POST, &$_COOKIE);
         while (list($k, $v) = each($in)) {

            foreach ($v as $key => $value) {

               if (!is_array($value)) {
                  $in[$k][$key] = stripslashes($value);
                  continue;
               }

               $in[] =& $in[$k][$key];

            }

         }

      }

   }


   /**
    * Prepares session according to settings
    */
   public static function prepareSession() {
      global $xConf;

      if ($xConf->dbSessions) {

         register_shutdown_function('session_write_close');

         session_set_save_handler(
            array("XSession", "open"),
            array("XSession", "close"),
            array("XSession", "read"),
            array("XSession", "write"),
            array("XSession", "destroy"),
            array("XSession", "clean")
         );

      }

   }

}
?>