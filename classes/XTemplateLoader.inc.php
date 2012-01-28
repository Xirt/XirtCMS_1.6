<?php

/**
 * Class that loads the main template for the current page
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XTemplateLoader {

   /**
    * @var The location of templates
    */
   const LOCATION = "%s/templates/%s/";


   /**
    * @var The name of the default (normal) template
    */
   const TPL_NORMAL = "template.tpl";


   /**
    * @var The name of the mobile template
    */
   const TPL_MOBILE = "mobile.tpl";


   /**
    * Constructor
    */
   function __construct() {
      $this->_load();
   }


   /**
    * Loads the requested template
    *
    * @access private
    */
   private function _load() {
      global $xConf;

      // AJAX Call
      if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
         return XInclude::component();
      }

      // No template
      if (!$xConf->showTemplate) {
         return XInclude::component();
      }

      // Admin Call
      if (defined('_ADMIN')) {
         return $this->_administration();
      }

      $this->_set();
      $this->_include();

   }


   /**
    * Includes the administration template
    *
    * @access private
    */
   private function _administration() {
      global $xConf, $xDb, $xLang;

      // Loads components
      $query = "SELECT *
                FROM #__components
                WHERE menu = 1";
      $xDb->setQuery($query);
      $components = $xDb->loadObjectList();

      // Show template
      $tpl = new XTemplate();
      $tpl->assign('xConf', $xConf);
      $tpl->assign('xLang', $xLang);
      $tpl->assign('componentsList', $components);
      $tpl->display('template/template.tpl');

   }


   /**
    * Includes the current template
    *
    * @access private
    */
   private function _include() {
      global $xConf, $xLang;

      $location = sprintf(self::LOCATION, $xConf->baseDir, $xConf->template);

      if ($xConf->mobile && is_readable($location . self::TPL_MOBILE)) {

         $tpl = new XTemplate();
         $tpl->assign('xConf', $xConf);
         $tpl->assign('xLang', $xLang);
         $tpl->display($location . self::TPL_MOBILE);

         return true;
      }

      if (is_readable($location . self::TPL_NORMAL)) {

         $tpl = new XTemplate();
         $tpl->assign('xConf', $xConf);
         $tpl->assign('xLang', $xLang);
         $tpl->display($location . self::TPL_NORMAL);

         return true;
      }

      trigger_error('Template file is not readable.', E_USER_ERROR);

   }

   /**
    * Sets the current template (according to page details)
    *
    * @access private
    * @throws XException
    */
   private function _set() {
      global $xConf, $xPage;

      $options = array();
      $list = Xirt::getTemplates();

      // Assigned templates
      foreach ($list as $tpl => $details) {

         if (!$details->published) {
            continue;
         }

         if (strstr($details->pages, "|{$xPage->cId}|")) {
            $options[] = $tpl;
         }
      }

      // Other templates
      if (!count($options)) {

         foreach ($list as $tpl => $details) {

            if (!$details->published) {
               continue;
            }

            if ($details->active) {
               $active = $tpl;
            }

            if (strstr($details->pages, '|all|')) {
               $options[] = $tpl;
            }
         }

      }

      // No template (fallback to 'active')
      if (!count($options)) {
         $options[] = $active;
      }

      // Select template
      if (!in_array($xConf->template, $options)) {
         $xConf->setTemplate(current($options));
      }

   }

}
?>
