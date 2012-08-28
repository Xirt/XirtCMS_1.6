<?php

/**
 * Class that loads main content of the requested page
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XPage {

   /**
    * @var The cId of the current page
    */
   var $cId = null;


   /**
    * @var List holding all (sub)titles for the page (TITLE-tag)
    */
   var $_titles = array();


   /**
    * @var List holding all meta tags for the page
    */
   var $_metatags = array();


   /**
    * @var List holding all js files for the page
    */
   var $_scripts = array();


   /**
    * @var List holding all css files for the page
    */
   var $_stylesheets = array();


   /**
    * @var List holding all MSEI-CSS files for the page (version 8 and lower)
    */
   var $_stylesheetsMSIE = array();


   /**
    * @var Variables holding the page content for showing
    */
   var $_content = null;


   /**
    * @var Array Keeps status of cached items
    */
   var $cached = array();


   /**
    * CONSTRUCTOR
    */
   function __construct() {

      $this->cId = XTools::getParam('cid', 0, _INT);

      $this->cached = array(
         'content' => true,
         'headers' => true
      );

   }


   /**********************/
   /* PRELOADING METHODS */
   /**********************/

   /**
    * Preloads component and headers
    *
    * @param $configureHeaders Toggles default meta information / headers
    */
   public function preload($configureHeaders = true) {
      global $xConf, $xLang;

      if ($configureHeaders) {

         $this->setTitle($xConf->title);

         $this->addInformation('robots',    'noindex, follow');
         $this->addInformation('language',  $xConf->language);
         $this->addInformation('generator', $xLang->version);

         $this->addStylesheet('../templates/xcss/xirt.css', 0);
         $this->addStylesheet('../templates/xcss/xlist.css', 0);
         $this->addStylesheet('../templates/xcss/msie.css', 0, true);

         $this->addScript(sprintf('languages/%s.js', $xConf->language));
         $this->addScript('../js/mootools.js');
         $this->addScript('../js/mootoolsmore.js');
         $this->addScript('../js/mootoolscustom.js');
         $this->addScript('../js/xvalidate.js');
         $this->addScript('../js/xlist.js');
         $this->addScript('../js/xadmin.js');
         $this->addScript('../js/xirt.js');

      }

      ob_start();
      $this->_load();
      $this->_content = ob_get_clean();

   }


   /**
    * Preloads main component
    *
    * @access private
    */
   private function _load() {
      global $xConf, $xUser;

      // Unauthorized requests (login panel)
      if (!$xUser->isAuth($xConf->adminLevel)) {

         if ($component = $this->_loadManager('adm_login')) {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
               return $component->showAjax();
            }

            return $component->showNormal();
         }

         return Xirt::notAuthorized();
      }

      // Authorized request
      $component = XTools::getParam('content');
      switch (substr($component, 0, 3)) {

         case 'adm':
            $component = $this->_loadManager($component);
            break;

         case 'com':
            $component = $this->_loadComponent($component);
            break;

         default:
            $component = $this->_loadManager('adm_portal');
            break;

      }

      switch (true) {

         case ($component === null):
            return null;

         case array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER):
            return $component->showAjax();

         default:
            return $component->showNormal();

      }

   }



   /***************************/
   /* EXTERNAL CONFIG METHODS */
   /***************************/

   /**
    * Sets the title
    *
    * @param $str String containing the new title
    */
   public static function setTitle($str) {
      global $xPage;

      $xPage->_titles = array($str);

   }


   /**
    * Extends the title
    *
    * @param $str String containing the new title extension
    */
   public static function extendTitle($str, $prepend = false) {
      global $xPage;

      if ($prepend && count($xPage->_titles)) {
         return array_unshift($xPage->_titles, $str);
      }

      $xPage->_titles[] = $str;

   }


   /**
    * Adds / overwrites META-tag
    *
    * @param $type String containing the property (type) of the META-tag
    * @param $value String containing the value of the META-tag
    */
   public static function addInformation($type, $value) {
      global $xPage;

      if ($type && $value) {
         $xPage->_metatags[$type] = $value;
      }

   }


   /**
    * Adds a CSS-tag (with priority)
    *
    * @param $file String with path to filename
    * @param $prio int for setting the priority of the file (defaults 1)
    * @param $msie int toggling MS Internet Explorer only modus (version 8-)
    */
   public static function addStylesheet($file, $prio = 1, $msie = 0) {
      global $xPage;

      if ($msie) {
         $xPage->_stylesheetsMSIE[$file] = $prio;
      } else {
         $xPage->_stylesheets[$file] = $prio;
      }

   }


   /**
    * Adds a SCRIPT-tag (for JavaScript files)
    *
    * @param $file String with path to filename
    */
   public static function addScript($file) {
      global $xPage;

      $xPage->_scripts[] = $file;
   }



   /*******************/
   /* LOADING METHODS */
   /*******************/

   /**
    * Loads a manager
    *
    * @access private
    * @param $name String containing the name of the manager to load
    * @return mixed The new instance of the manager or false / null on failure
    */
   private function _loadManager($name) {
      global $xConf, $xUser;

      // Check component
      $path = sprintf(XInclude::PATH_MANAGERS, $name);
      if (!is_readable($path)) {

         trigger_error("[XCore] Manager failure ({$name})", E_USER_WARNING);
         return Xirt::pageNotFound();

      }

      // Check authorization
      if (isset($xConf->$name) && !$xUser->isAuth($xConf->$name)) {

         Xirt::notAuthorized();
         return null;

      }

      require_once($path);
      return new Manager($name, $component->config);
   }


   /**
    * Loads a component
    *
    * @access private
    * @param $name String containing the name of the component to load
    * @return mixed The new instance of the component or false / null on failure
    */
   private function _loadComponent($name) {
      global $xConf, $xUser;

      // Find component
      $components = Xirt::getComponents();
      if (!array_key_exists($name, $components)) {

         trigger_error("[XCore] Component not found ({$name})", E_USER_WARNING);
         return Xirt::pageNotFound();

      }

      // Check authorization
      $component = $components[$name];
      if (!$xUser->isAuth($component->access_min, $component->access_max)) {

         Xirt::notAuthorized();
         return null;

      }

      // Check component
      $path = sprintf(XInclude::PATH_COMPONENTS, $name);
      if (!is_readable($path)) {

         trigger_error("[XCore] Component failure ({$name})", E_USER_WARNING);
         return Xirt::pageNotFound();

      }

      require_once($path);
      return new Component($name, $component->config);
   }

}
?>
