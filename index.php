<?php

/*******************************************
 ** @author     A.G. Gideonse              **
 ** @version    1.6                        **
 ** @copyright  XirtCMS 2010 - 2012        **
 ** @package    XirtCMS                    **
 *******************************************/

define('_XDIR', './');
define('_XIRT', true);
define('nl', "\n");

/**
 * Auto-Include required classes
 *
 * @param $class String containing the name of the class to load
 */
function xirt_autoload($class) {

   if (class_exists($class)) {
      return;
   }

   $file = 'classes/' . $class . '.inc.php';
   if (is_file($file)) {
      return require_once ($file);
   }

   trigger_error("Could not find class '{$class}'.", E_USER_ERROR);

}
spl_autoload_register('xirt_autoload');
set_include_path('.');

new XEngine();
?>
