<?php

/**
 * Creates a language file from given input
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XLanguage {

   /**
    * @var String The location of the language files
    */
   const LOCATION = 'languages/%s.ini';


   /**
    * @var String The location of the JavaScript language files
    */
   const LOCATION_JS = 'languages/%s.js';


   /**
    * @var String The location of the language files for extensions
    */
   const LOCATION_EXT = 'languages/%s/%s.ini';


   /**
    * Constructor
    *
    * @param $iso The ISO value of the language to load
    */
   function __construct($iso) {
      $this->language = $iso;
   }


   /**
    * Attempts to load the requested language file
    *
    * @param $file The language file to load (extensions only)
    * @throws Exception on failure
    */
   function load($file = null) {

      if (!is_null($file)) {
         return $this->_loadForExtension($file);
      }

      $javascript = sprintf(self::LOCATION_JS, $this->language);
      if (!is_readable($javascript)) {
         trigger_error("Failed to load language 'ISO' (JS).", E_USER_WARNING);
      }

      $file = sprintf(self::LOCATION, $this->language);
      if (!$file || !is_readable($file)) {

         trigger_error("Failed to load language 'ISO' (INI).", E_USER_ERROR);
         return;

      }

      if (!$strings = parse_ini_file($file, true)) {

         trigger_error("Failed to parse language 'ISO' (INI).", E_USER_ERROR);
         return;

      }

      XContent::addScriptTag($javascript);
      foreach ($strings as $key => $value) {
         $this->$key = $value;
      }

   }


   /**
    * Attempts to load a language file for an extension
    *
    * @param $ext The extension name of the extension
    * @throws Exception on failure
    */
   function _loadForExtension($ext) {

      $file = sprintf(self::LOCATION_EXT, $this->language, $ext);

      if (!$file || !is_readable($file)) {
         throw new Exception("Failed to read for {$ext}", E_USER_WARNING);
      }

      if (!$strings = parse_ini_file($file, true)) {
         throw new Exception("Failed to parse for {$ext}", E_USER_WARNING);
      }

      foreach ($strings as $key => $value) {
         $this->$key = $value;
      }

      return true;
   }

}
?>