<?php

/**
 * Utility class to include XirtCMS page items
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XInclude {


   /**
    * @var The default location of plugins (JS)
    */
   const PATH_PLUGINS = '../js/plugins/%s/plugin.js';


   /**
    * @var The default location of components
    */
   const PATH_COMPONENTS = './components/%s/index.com.php';


   /**
    * @var The default location of components
    */
   const PATH_MANAGERS = './managers/%s/index.adm.php';



   /****************************/
   /* EXTERNAL LOADING METHODS */
   /****************************/

   /**
    * Shows the head of the page (title, meta, css, js)
    */
   public static function header() {
      global $xConf, $xPage;

      // Prepare page title
      $title = implode(array_reverse($xPage->_titles), ' | ');

      // Prepare stylesheets
      asort($xPage->_stylesheets);
      asort($xPage->_stylesheetsMSIE);
      $xPage->_stylesheets = array_keys($xPage->_stylesheets);
      $xPage->_stylesheetsMSIE = array_keys($xPage->_stylesheetsMSIE);

      // Prepare JavaScript files (combine if requested)
      if (!$xConf->debugMode && $xConf->combineScripts) {

         $list = array();
         foreach ($xPage->_scripts as $key => $file) {

            if (strpos($file, '://') === false) {

               unset($xPage->_scripts[$key]);
               $list[] = $file;

            }

         }

         $xPage->_scripts[] = 'xjs/' . implode(',', $list);

      }

      // Show template
      $tpl = new XTemplate();
      $tpl->assign('xConf', $xConf);
      $tpl->assign('title', $title);
      $tpl->assign('scripts', $xPage->_scripts);
      $tpl->assign('metatags', $xPage->_metatags);
      $tpl->assign('stylesheets', $xPage->_stylesheets);
      $tpl->assign('stylesheets_ie', $xPage->_stylesheetsMSIE);
      $tpl->display('templates/xtemplates/display-header.tpl');

      $xPage->sentHeaders = true;

   }


   /**
    * Includes a plugin in the page (for JavaScript plugins)
    *
    * @param $type The plugin to load
    */
   public static function plugin($type) {
      global $xConf, $xPage;

      if (!defined('PLUGIN.' . $type)) {

         define('PLUGIN.' . $type, 1);
         $path = sprintf(self::PATH_PLUGINS, $type);

         // Find plugin
         if (!file_exists($path)) {

            trigger_error("[XCore] Plugin not found ({$type})", E_USER_NOTICE);
            return false;

         }

         // Include plugin (header)
         if (!$xPage->cached['headers']) {
            return XPage::addScript($path);
         }

         // Include plugin (content)
         $tpl = new XTemplate();
         $tpl->assign('xConf', $xConf);
         $tpl->assign('script', $path);
         $tpl->display('templates/xtemplates/display-script.tpl');

      }

   }


   /**
    * Shows the main content of the site (after preloading)
    */
   public static function component() {
      global $xPage;

      if ($xPage->cached['content']) {

         $xPage->cached['content'] = false;
         print($xPage->_content);

      }

   }


   /**
    * Shows parsing knowledge in debug mode (default behavior)
    *
    * @param $ignore When true, statistics are always shown
    */
   public static function statistics($ignore = false) {
      global $xConf, $xDb, $xStart;

      if (!$xConf->debugMode || $ignore) {
         return false;
      }

      // Show template
      $tpl = new XTemplate();
      $tpl->assign('memoryUse', round(memory_get_peak_usage() / 1048576, 3));
      $tpl->assign('parseTime', round(XTools::getMicrotime() - $xStart, 3));
      $tpl->assign('queryTime', round($xDb->timer, 3));
      $tpl->assign('queryCount', count($xDb->cache));
      $tpl->display('templates/xtemplates/display-statistics.tpl');

   }

}
?>