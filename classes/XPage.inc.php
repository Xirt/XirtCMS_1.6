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

         $this->addInformation('robots',        'index, follow');
         $this->addInformation('language',      $xConf->language);
         $this->addInformation('keywords',      $xConf->keywords);
         $this->addInformation('generator',     $xLang->version);
         $this->addInformation('description',   $xConf->description);

         $this->addStylesheet('templates/xcss/xirt_front.css', 0);

         $this->addScript(sprintf('languages/%s.js', $xConf->language));
         $this->addScript('js/mootools.lib.js');
         $this->addScript('js/mootoolsmore.lib.js');
         $this->addScript('js/mootoolscustom.lib.js');
         $this->addScript('js/xvalidate.lib.js');
         $this->addScript('js/xirt.lib.js');


      }

      ob_start();
      $this->_load();
      $this->_content = ob_get_clean();

   }


   /**
    * Preloads main component
    *
    * @access private
    * @param $content The content item to load (optional)
    */
   private function _load($content = null) {

      if (is_null($content) || !$content) {
         $content = XTools::getParam('content');
      }

      switch (substr($content, 0, 3)) {

         case 'com':

            if (!$component = $this->_loadComponent($content)) {
               break;
            }

            switch (true) {

               case XTools::isMobileRequest():
                  return $component->showMobile();

               case array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER):
                  return $component->showAjax();

               default:
                  return $component->showNormal();

            }

         break;

         case 'mod':

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
               return $this->_loadModule($content);
            }

            //$alternative = XTools::getParam('content', null, null, true);
            //if (isset($alternative) && $content != $alternative) {
            //   return $this->_preload($alternative);
            //}

            Xirt::pageNotFound();
         break;

         default:
            $this->_loadFrontpage();
         break;

      }

   }


   /**
    * Preloads the homepage (or redirects to homepage URL on failure)
    *
    * @access private
    * @return null
    */
   private function _loadFrontpage() {
      global $xDb, $xPage;

      // Database query
      $query = 'SELECT xid, link, link_type ' .
               'FROM #__menunodes           ' .
               'WHERE home = 1              ';

      // Retrieve data
      $stmt =  $xDb->prepare($query);
      $stmt->execute();

      // Checks validity of link
      if (!($home = $stmt->fetchObject()) || $home->link == 'index.php') {
         trigger_error("[XCore] Homepage unknown", E_USER_ERROR);
      }

      // Checks type of link (must be internal link)
      if (!in_array($home->link_type, array(0, 1, 2))) {
         trigger_error("[XCore] Invalid Homepage link", E_USER_ERROR);
      }

      // Redirect to homepage (old method, always redirect)
      //$seperator = strpos($home->link, '?') ? '&' : '?';
      //$location = sprintf("%s%scid=%d", $home->link, $seperator, $home->xid);
      //die(header('Location: ' . $location));

      // Forward SEF/Simple URLs
      if (!$query = parse_url($home->link, PHP_URL_QUERY)) {
         die(header('Location: ' . $link));
      }

      unset($_GET, $_POST);
      parse_str($query, $parameters);

      // Set home parameters
      $_GET['cid'] = $home->xid;
      foreach ($parameters as $key => $value) {
         $_GET[$key] = $value;
      }

      // Attempt reload
      $xPage->cId = $home->xid;
      $this->_load();

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
    */
   public static function addStylesheet($file, $prio = 1) {
      global $xPage;

      $xPage->_stylesheets[$file] = $prio;
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
    * Loads a component
    *
    * @access private
    * @param $name String containing the name of the component to load
    * @return mixed The new instance of the component or false / null on
    */
   private function _loadComponent($name) {
      global $xConf, $xUser;

      // Find component
      $components = Xirt::getComponents();
      if (!array_key_exists($name, $components)) {

         trigger_error("[Core] Component not found ({$name})", E_USER_WARNING);
         return Xirt::pageNotFound();

      }

      // Check authorization
      $component = $components[$name];
      if (!$xUser->isAuth($component->access_min, $component->access_max)) {

         Xirt::notAuthorized();
         return null;

      }

      // Check component
      $path = sprintf(XInclude::PATH_COMPONENTS, $xConf->baseDir, $name);
      if (!is_readable($path)) {

         trigger_error("[XCore] Component failure ({$name})", E_USER_WARNING);
         return Xirt::pageNotFound();

      }

      require_once($path);
      return new Component($name, $component->config);
   }


   /**
    * Loads a module (for AJAX calls)
    *
    * @access private
    * @param $type String containing the name of the module to load
    * @return mixed The generated instance of the module or false
    */
   private function _loadModule($type) {
      global $xConf, $xUser;

      $list = new XModuleList();
      $list->filterByType($type);
      $list = $list->toArray();

      // Find module
      if (!count($list) || !$module = current($list)) {

         trigger_error("[XCore] Module not found ({$type})", E_USER_WARNING);
         return false;

      }

      // Check module
      $path = sprintf(XInclude::PATH_MODULES, $xConf->baseDir, $type);
      if (!is_readable($path)) {

         trigger_error("Module failure ({$type})", E_USER_WARNING);
         return false;

      }

      require_once($path);
      return new $type($module->config);
   }

}
?>