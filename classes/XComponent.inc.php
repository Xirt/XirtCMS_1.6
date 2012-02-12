<?php

/**
 * The default Component for XirtCMS (to be extended)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XComponent {

   /**
    * @var The name of the module instance
    */
   var $name = null;


   /**
    * @var The language file for the module instance
    */
   var $xLang = null;


   /**
    * @var The settings for the module instance
    */
   var $xConf = array();


   /**
    * Initializes object with optional language file and settings
    *
    * @param $name String with the name of the component
    * @param $config String with JSON instance configuration (optional)
    */
   function __construct($name, &$config = null) {
      global $xCom;

      $this->__init($name, $config);
      $xCom = $this;

   }


   /**
    * Sets module preferences / information
    *
    * @param $name String with the name of the component
    * @param $config JSON String containing the instance configuration
    * @access private
    */
   private function __init($name, &$config) {

      $this->name  = $name;
      $this->xConf = json_decode($config);
      $this->xLang = $this->__language();

   }


   /**
    * Returns the language object for the current component
    *
    * @access private
    * @return mixed The language object on success, NULL otherwhise
    */
   private function __language() {

      foreach (Xirt::getLanguages(true) as $language) {

         try {

            $language = new XLanguage($language->iso);
            $language->load($this->name);

            return $language;

         } catch (Exception $e) {}

      }

      return null;

   }


   /**
    * Shows content for regular request
    */
   function showNormal() {
      trigger_error("No showNormal() in ({$this->name})", E_USER_ERROR);
   }


   /**
    * Shows content for AJAX request
    */
   function showAjax() {
      trigger_error("No showAJAX() in ({$this->name})", E_USER_WARNING);
   }


   /**
    * Shows content for mobile request
    */
   function showMobile() {
      $this->showNormal();
   }

}
?>