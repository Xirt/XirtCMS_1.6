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
    *
    * @param $module String with the name (type) of the requested model
    * @return Object Default configuration for the given module
    */
   public static function getConfiguration($module) {
      global $xConf;

      $path = $xConf->baseDir . "modules/";
      $file = $module . "/index.mod.xml";

      try {

         $moduleInfo = new SimpleXMLElement($path . $file, null, true);

         $config = (Object)array();
         if (!isset($moduleInfo->params->param)) {
            return $config;
         }

         foreach ($moduleInfo->params->param as $param) {

            if (!$type = strval($param->attributes()->type)) {
               trigger_error("Incorrect configuration ({$mod})", E_USER_WARNING);
            }

            $field = (Object) array();

            foreach ($param->attributes() as $attrib => $value) {
               $field->$attrib = strval($value);
            }

            if ($type == 'select' || $type == 'radio') {

               $options = (Object) array();

               foreach ($param->option as $option) {

                  $name  = strval($option->attributes()->name);
                  $value = strval($option->attributes()->value);
                  $options->$name = $value;

               }

               $field->options = $options;

            }

            $config->{$field->name} = $field;

         }

      } catch (Exception $e) {

         trigger_error("Module XML invalid ({$module}).", E_USER_WARNING);

      }

      return $config;
   }


   /**
    * Returns the location of the module in the filesystem
    *
    * @access protected
    * @return String The relative location of the module
    */
   protected function _location() {
      return sprintf('modules/%s/', $this->type);
   }

}
?>
