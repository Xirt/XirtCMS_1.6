<?php

/**
 * Customizable class containing all main configuration settings
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XConfiguration extends DefaultConfiguration {

   /**
    * @var boolean The current language
    */
   var $language  = null;


   /**
    * @var boolean Toggles normal/mobile website
    */
   var $mobile = false;


   /**
    * @var boolean The current template
    */
   var $template  = null;


   /**
    * @var boolean Toggles displaying the template (defaults true)
    */
   var $showTemplate  = true;


   /**
    * Extends the customized configuration file and sets initial values
    */
   function __construct() {

      parent::__construct();

      date_default_timezone_set($this->timezone);

      $this->language = $this->_getLanguage();
      $this->template = $this->_getTemplate();
      $this->baseURL  = $this->_getBaseURL();
      $this->siteURL  = $this->_getSiteURL();
      $this->baseDir  = $this->_getBaseDir();
      $this->logDir   = $this->_getLogDir();
      $this->mobile   = $this->_getMobile();

   }


   /**
    * Sets a new language to use on the website
    *
    * @param $iso The new language (ISO format)
    */
   public function setLanguage($iso) {

      $_SESSION['language'] = $iso;
      $this->language = $iso;

   }


   /**
    * Sets a new template to use on the website
    *
    * @param $tpl The new template
    */
   public function setTemplate($tpl) {

      $_SESSION['template'] = $tpl;
      $this->template = $tpl;

   }


   /**
    * Toggles showing the template
    *
    * @param $toggle Toggle for showing/hiding the template (optional)
    */
   public function showTemplate($toggle = true) {
      $this->showTemplate = $toggle;
   }


   /**
    * Toggles hiding the template
    *
    * @param $toggle Toggle for showing/hiding the template (optional)
    */
   public function hideTemplate($toggle = true) {
      $this->showTemplate(!$toggle);
   }


   /**
    * Return current setting for the language
    *
    * @access private
    * @return String The current language
    */
    private function _getLanguage() {

      if (defined('_ADMIN')) {
         return $this->admLanguage;
      }

      if ($iso = XTools::getParam('lang')) {
         $this->setLanguage($iso);
         return $iso;
      }

      // This block is included for backwards-compatibility
      if ($iso = XTools::getParam('cLang')) {
         $this->setLanguage($iso);
         return $iso;
      }

      if (isset($_SESSION['language'])) {
         return $_SESSION['language'];
      }

      return $this->language;
   }


   /**
    * Return current setting for the template
    *
    * @access private
    * @return String The current template
    */
   private function _getTemplate() {

      if (!$this->showTemplate) {
         return null;
      }

      if ($tpl = XTools::getParam('tpl')) {
         $this->setTemplate($tpl);
         return $tpl;
      }

      if (isset($_SESSION['template'])) {
         return $_SESSION['template'];
      }

      return $this->template;
   }


   /**
    * Return the current base url for the XirtCMS installation
    *
    * @access private
    * @return String The current baseURL
    */
   private function _getBaseURL() {

      $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
      $script = dirname($_SERVER['SCRIPT_NAME']);

      if (!$server = $_SERVER['HTTP_HOST']) {
         $server = $_SERVER['SERVER_NAME'];
      }

      $server = $_SERVER['SERVER_NAME'];
      if ($_SERVER['SERVER_PORT'] != '80') {
         $server = $server . ':' .$_SERVER['SERVER_PORT'];
      }

      return $protocol . $server . str_replace('//', '/', $script . '/');
   }


   /**
    * Return the site url for the XirtCMS installation
    *
    * @access private
    * @return String The current siteURL
    */
   private function _getSiteURL() {

      if (!defined('_ADMIN')) {
         return $this->baseURL;
      }

      return dirname($this->baseURL) . '/';
   }


   /**
    * Returns the installation directory for the XirtCMS installation
    *
    * @access private
    * @return String The installation directory
    */
   private function _getBaseDir() {
      return realpath(dirname($_SERVER['SCRIPT_FILENAME']) . '/' . _XDIR) . '/';
   }


   /**
    * Returns the logfile directory for the XirtCMS installation
    *
    * @access private
    * @return String The logfile directory

    */
   private function _getLogDir() {
      return realpath($this->baseDir . 'logs/') . '/';
   }


   /**
    * Returns the mobile status of the current website
    *
    * @access private
    * @return boolean The current status
    */
   private function _getMobile() {

      $mobile = XTools::getParam('mobile', null);

      if ($mobile !== null && is_numeric($mobile)) {
         $_SESSION['mobile'] = $mobile;
      }

      if (isset($_SESSION['mobile'])) {
         return $_SESSION['mobile'];
      }

      return XTools::isMobileRequest();
   }

}
?>