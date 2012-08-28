<?php

/**
 * Defined constants for XTools:getParam()
 */
define('_BOOL',   'bool');
define('_INT',    'int');
define('_FLOAT',  'float');
define('_STRING', 'string');
define('_ARRAY',  'array');
define('_OBJECT', 'object');


/**
 * Utility class with abstract functions to support XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class XTools {

   /**********************************/
   /* Functions supporting Xirt Core */
   /**********************************/

   /**
    * Returns value of a param (GET, POST) defined by the params
    *
    * @param $var The param to return
    * @param $return The default value of the param (optional)
    * @param $type The type to return (optional)
    * @param $force Forces the usage of the _GET instead _POST (optional)
    * @return Mixed the value of the param or the default value
    */
   public static function getParam($var, $return = null, $type = null,
      $force = null) {

      if (!$force && isset($_POST[$var])) {
         $return = $_POST[$var];
      } elseif (isset($_GET[$var])) {
         $return = $_GET[$var];
      }

      if (!is_null($type)) {
         settype($return, $type);
      }

      return $return;
   }


   /**
    * Returns a link based on the given params
    *
    * @param $link The base value of the link
    * @param $cId The cId of the link (optional, defaults 0)
    * @param $name The SEF value to use (optional, defauls 'index')
    * @return String The created link
    */
   public static function createLink($link, $cId = 0, $name = 'index') {
      global $xConf;

      if ($xConf->alternativeLinks) {
         return XSEF::convert($link, $cId, $name);
      }

      return htmlspecialchars($cId ? $link . '&cid=' . $cId : $link);
   }


   /**
    * Attempts to detect mobile browsing visitors
    *
    * @return boolean True for known mobile devices, false otherwhise
    */
   public static function isMobile() {

      $mobiles = array(
         '/symbian/i',
         '/android*mobile/i',
         '/ipad|ipod|iphone/i',
         '/blackberry|rim tablet os/i',
         '/(windows ce|windows phone os)/i',
		   '/(kindle|psp|up.browser|opera mini)/i',
		   '/(mobile|mmp|midp|pocket|smartphone|wap)/i',
         '/(palm|hiptop|avantgo|plucker|xiino|blazer|elaine|treo)/i'
      );

      // Check mobile agents
      foreach ($mobiles as $mobile) {

         if (preg_match($mobile, $_SERVER['HTTP_USER_AGENT'])) {
            return true;
         }

      }

      // Check requested formats
      $accepts = $_SERVER['HTTP_ACCEPT'];
      if (strpos($accepts, 'application/vnd.wap.xhtml+xml') > 0) {
         return true;
      }

      if (strpos($accepts, 'text/vnd.wap.wml') > 0) {
         return true;
      }

      // Check for WAP profiles
      if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
         return true;
      }

      if (isset($_SERVER['HTTP_PROFILE'])) {
         return true;
      }

      return false;
   }



   /**********************/
   /* Escaping functions */
   /**********************/

   /**
    * Encodes a variable using PHP's htmlspecialchars
    *
    * @param $var The variable to encode
    * @return Mixed The encoded variable
    */
   public static function encodeHTML($var) {

      if (!is_array($var) && !is_object($var)) {

         $var = htmlspecialchars($var, ENT_QUOTES);
         return stripslashes($var);

      }

      foreach ($var as $key => $value) {
         $var->$key = XTools::encodeHTML($value);
      }

      return $var;
   }


   /**
    * Adds slashes to variables (mixed types)
    *
    * @param $var The variable to escape
    * @return Mixed The escaped variable
    */
   public static function addslashes($var) {

      if (!is_array($var) && !is_object($var)) {
         return addslashes($var);
      }

      foreach ($var as $key => $value) {

         if (is_object($var)) {

            $var->$key = XTools::addslashes($value);
            continue;

         }

         $var[$key] = XTools::addslashes($value);

      }

      return $var;
   }


   /**
    * Removes all disallowed tags/attributes from HTML input
    *
    * @param $var The variable to check
    * @return Mixed The stripped variable
    */
   public static function stripTags($var) {

      if (is_array($var) || is_object($var)) {

         foreach ($var as $key => $value) {
            $var->$key = XTools::stripTags($value);
         }

         return $var;
      }

      // Allowed tags
      $tags = array(
         '<blockquote>', '<span>', '<p>', '<br>', '<ol>', '<ul>', '<li>',
         '<sub>', '<sup>', '<u>', '<em>', '<strike>', '<strong>', '<img>',
         '<a>'
      );

      // Allowed attributes
      $attribs = sprintf(

         "/ [^ =]*(?<!%s)=(\"[^\"]*\"|\'[^\']*\')/i",
         implode(')(?<!', array(
            'name', 'href', 'title', 'style', 'target',
            'rel', 'class', 'src', 'alt'
         ))

      );

      // Strip content
      $var = strip_tags($var, implode('', $tags));
      preg_match_all('/<[^>]*>/i', $var, $tags);

      foreach ($tags[0] as $tag) {

         if ($replacement = preg_replace($attribs, '', $tag)) {
            $var = str_replace($tag, $replacement, $var);
         }

      }

      return $var;
   }



   /*****************/
   /* Miscellaneous */
   /*****************/


   /**
    * Returns a random alphanumeric password
    *
    * @param $length The length of the password (optional, defaults 8)
    * @return String The created password
    */
   public static function generatePassword($length = 8) {

      $charset = array();
      $charset[] = range('a', 'z');
      $charset[] = range('A', 'Z');
      $charset[] = range('0', '9');

      do {

         $list = array();

         for ($i = 0; $i < $length; $i++) {

            $group = $charset[array_rand($charset)];
            $list[] = $group[array_rand($group)];

         }

         $password = implode($list);

      } while (!XValidate::isPassword($password));

      return $password;
   }


   /**
    * Shows a WYSIWYG editor with full functionality
    *
    * @param id The ID of the textarea / editor
    * @param $str The content of the textarea / editor
    * @return boolean Returns true for WYSIWYG-editors, false otherwise
    */
   public static function showEditor($id, $style = null, $str = null) {
      global $xConf, $xUser;

      if (defined('_ADMIN') && !$xUser->editor) {

         $tpl = new XTemplate();
         $tpl->assign('id', $id);
         $tpl->assign('content', $str);
         $tpl->display('templates/xtemplates/display-editor.tpl');

         return false;
      }

      if (defined('_ADMIN')) {
         $xConf->template = current(Xirt::getTemplates())->folder;
      }

      // Editor style
      $cssList = array();
      $cssList[] = 'templates/xcss/xirt_front.css';
      $cssList[] = 'templates/' . $xConf->template . '/css/main.css';
      $cssList[] = 'templates/xcss/ckeditor.css';

      // Initialize editor
      $editor = new CKEditor();
      $editor->initialized = true;

      // Set configuration
      $config = array();
      $config['toolbar'] = $style ? $style : 'Full';
      $config['language'] = $xConf->language;
      $config['baseHref'] = $xConf->siteURL;
      $config['contentsCss'] = $cssList;

      // Show editor
      $editor->editor($id, $str, $config);
      return true;
   }


   /**
    * Shows a WYSIWYG editor with basic functionality
    *
    * @deprecated
    * @param $id The ID of the textarea / editor
    * @param $str The content of the textarea / editor
    * @return boolean Returns true for WYSIWYG-editors, false otherwise
    */
   public static function showSimpleEditor($id, $str = null) {
      return XTools::showSimpleEditor($id, 'simple', $str);
   }


   /**
    * Returns a str of the given length filled with a given character
    *
    * @param $char The character to use (optional, default '&nbsp;')
    * @param $length The length of the indentation (optional, default 3)
    * @return String The generated string
    */
//    public static function createIdentation($char = '&nbsp;', $length = 3) {
//
//      $str = '';
//      for ($i = 0; $i < $length; $i++) {
//         $str = $str . $char;
//      }
//
//      return $str;
//   }


   /**
    * Returns a shortened version of a string to use as summary
    *
    * @param $str The original String
    * @param $length The length of the summary
    * @param $min The minimum length a word needs to break the String
    * @return Returns The shortened version of the String
    */
//   public static function createSummary($str, $length, $min = 3) {
//
//      $pos = 0;
//      $list = '';
//
//      foreach (explode(' ', $str) as $word) {
//
//         $list[] = $word;
//         $pos = $pos + strlen($word) + 1;
//
//         if ($pos >= $length && strlen($word) > $min) {
//            break;
//         }
//
//      }
//
//      return implode(' ', $list) . (($pos < strlen($str)) ? '...' : '');
//   }



   /****************/
   /* Time related */
   /****************/

   /**
    * Returns the microtime since UNIX Epoch (0:00:00 January 1, 1970 GMT)
    *
    * @deprecated
    * @return float Containing the time passed since UNIX Epoch
    */
   public static function getmicrotime() {
      trigger_error("[XTools] Deprecated 'microtime()'", E_USER_WARNING);
      return XDateTime::getmicrotime();
   }


   /**
    * Returns a full date (including day using language files)
    *
    * @deprecated
    * @param $stamp The timestamp to use (optional, defaults NOW)
    * @param $showTime Toggles time (optional, defaults false)
    * @return String The generated date string
    */
   public static function getFullDate($stamp = null, $showTime = false) {
      trigger_error("[XTools] Deprecated 'getFullDate()'", E_USER_WARNING);
      return XDateTime::getFullDate($stamp, $showTime);
   }


   /**
    * Returns a relative date (relative to NOW)
    *
    * @deprecated
    * @param $stamp The timestamp to use
    * @return String The generated date string
    */
   public static function getRelativeDate($stamp) {
      trigger_error("[XTools] Deprecated 'getRelativeDate()'", E_USER_WARNING);
      return XDateTime::getRelativeDate($stamp);
   }

}
?>
