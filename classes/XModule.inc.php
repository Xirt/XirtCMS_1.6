<?php

/**
 * The default Module for XirtCMS (to be extended)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XModule {

   /**
    * @var The path to modules
    */
   const PATH = '%smodules/%s/';


   /**
    * @var The path to the configuration file of modules
    */
   const PATH_XML = '%smodules/%s/index.mod.xml';


   /**
    * @var The name of the module instance
    */
   var $type = null;


   /**
    * @var The language file for the module instance
    */
   var $xLang = null;


   /**
    * @var The settings for the module instance
    */
   var $xConf = array();


   /**
    * CONSTRUCTOR
    *
    * @param $config JSON String containing the instance configuration
    */
   function __construct(&$config) {
      global $xConf;

      $this->__init($config);

      switch (true) {

         case array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER):
            return $this->showAJAX();

         case $xConf->mobile:
            return $this->showMobile();

      }

      return $this->showNormal();
   }


   /**
    * Sets module preferences / information
    *
    * @param $config JSON String containing the instance configuration
    * @access private
    */
   private function __init(&$config) {

      $this->type  = get_class($this);
      $this->xConf = json_decode($config);
      $this->xLang = $this->__language();

   }


   /**
    * Returns the language object for the current module
    *
    * @access private
    * @return mixed The language object on success, NULL otherwhise
    */
   private function __language() {

      foreach (Xirt::getLanguages(true) as $language) {

         try {

            $language = new XLanguage($language->iso);
            $language->load($this->type);

            return $language;

         } catch (Exception $e) {}

      }

      return null;
   }


   /**
    * Shows content for regular request
    */
   function showNormal() {
      trigger_error("No showNormal() in ({$this->type})", E_USER_WARNING);
   }


   /**
    * Shows content for AJAX request
    */
   function showAJAX() {
      trigger_error("No showAJAX() in ({$this->type})", E_USER_WARNING);
   }


   /**
    * Shows content for mobile request
    */
   function showMobile() {
      $this->showNormal();
   }


   /**
    * Returns the default configuration for the given module
    * NOTE: Do not use ArrayObject. Support for json_encode() is lacking up to
    * at least version 5.3.x
    *
    * @param $type String with the name (type) of the requested model
    * @return Object Default configuration for the given module
    */
   public static function getConfiguration($type) {
      global $xConf;

      $configuration = array();

      try {

         $path = sprintf(XModule::PATH_XML, $xConf->baseDir, $type);
         $module = @new SimpleXMLElement($path, null, true);

      } catch (Exception $e) {

         trigger_error("[XCore] Module invalid ({$type})", E_USER_WARNING);
         return $configuration;

      }

      // No parameters
      if (!isset($module->params->param)) {
         return $configuration;
      }

      // Iterate over parameters
      foreach ($module->params->param as $param) {

         $parameter = (object)array();
         foreach ($param->attributes() as $attrib => $value) {
            $parameter->$attrib = strval($value);
         }

         // Check parameter
         if (!isset($parameter->type, $parameter->name, $parameter->default)) {

            trigger_error("[XCore] Module invalid ({$type})", E_USER_WARNING);
            continue;

         }

         // Special parameter types (with options)
         if (in_array($parameter->type, array('select', 'radio'))) {

            $parameter->options = array();
            foreach ($param->option as $option) {

               $name  = strval($option->attributes()->name);
               $value = strval($option->attributes()->value);
               $parameter->options[$name] = $value;

            }

         }

         $configuration[$parameter->name] = $parameter;

      }

      return $configuration;
   }


   /**
    * Returns the location of the module in the filesystem
    *
    * @access protected
    * @return String The relative location of the module
    */
   protected function _location() {
      global $xConf;

      return sprintf(self::PATH, $xConf->baseDir, $this->type);
   }

}
?>