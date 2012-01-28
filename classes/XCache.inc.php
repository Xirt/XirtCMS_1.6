<?php

/**
 * Class that handles caching of files and content
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XCache {

   /**
    * The time (in seconds) before the cache items expire (for files)
    */
   static $DURATION = 1800;


   /**
    * The prefix for cached files
    */
   static $FILE_PREFIX = 'file.';


   /**
    * Saves a value in the cache
    *
    * @param $identifier The identifier to save / get the value from cache
    * @param $value The value to save in the cache
    */
   function set($identifier, $value) {
      $this->$identifier = $value;
   }


   /**
    * Loads a value from the cache
    *
    * @param $identifier The identifier to save / get the value from cache
    */
   function get($identifier) {

      return (isset($this->$identifier) ? $this->$identifier : null);
   }


   /**
    * Removes a value from the cache
    *
    * @param $identifier The identifier to save / get the value from cache
    */
   function forget($identifier) {
      unset($this->$identifier);
   }


   /**
    * Returns the contents of a file
    *
    * @param $file The file or URI to load
    * @return String The contents of the requested file
    */
   function loadFile($file) {

      $cacheFile = $this->_getCacheName($file, true);
      $expiry = time() - self::$DURATION;

      if (!file_exists($cacheFile) || filemtime($cacheFile) < $expiry) {
         $this->_saveFile($cacheFile, $file);
      }

      return file_get_contents($cacheFile);
   }


   /**
    * Copies a file to the cache
    *
    * @access private
    * @param $cacheFile The destination file in the cache
    * @param $file The file or URI to cache
    */
   function _saveFile($cacheFile, $file) {

      $contents = file_get_contents($file);
      file_put_contents($cacheFile, $contents);

   }


   /**
    * Returns the contents of a file
    *
    * @access private
    * @param $file The original name
    * @return String The name of the file in the cache
    */
   function _getCacheName($name) {
      global $xConf;

      $file = self::$FILE_PREFIX . md5($name);

      return sprintf('%scache/%s', $xConf->baseDir, $file);
   }

}
?>