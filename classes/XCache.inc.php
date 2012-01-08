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
    * The time (in seconds) before the cache items expire
    */
   static $DURATION = 1800;


   /**
    * The prefix for cached content
    */
   static $TXT_PREFIX = 'txt.';


   /**
    * The prefix for cached files
    */
   static $FILE_PREFIX = 'file.';


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
    * @param $isFile booleaan indicating whether the content is a file or text
    * @return String The name of the file in the cache
    */
   function _getCacheName($name, $isFile = false) {
      global $xConf;

      $file = ($isFile ? self::$FILE_PREFIX : self::$TXT_PREFIX) . md5($name);

      return sprintf('%scache/%s', $xConf->baseDir, $file);
   }

}
?>