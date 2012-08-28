<?php
/************************************************************************
 * CSS and Javascript Combinator 0.5
 * Copyright 2006 by Niels Leenheer
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * A.G. Gideonse (11/01/2012):
 * This is a modified Object Oriented-version of the orginal script (version
 * 0.5) and only handles JavaScript files (which impacts performance of the
 * CMS the most). CSS files are harded to combine as they they are more path
 * dependent (for images).
 */

$base     = realpath(dirname(__FILE__));
$cacheDir = dirname(__FILE__) . '/cache';
$files    = isset($_GET['files']) ? explode(',', $_GET['files']) : array();

/**
 * Class to combine multiple JavaScript files into one encoded file
 *
 * @modifier   A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Combine {

   /**
    * Constructor
    *
    * @param $base The base path of the file
    * @param $cacheDir The cache directory to use
    * @param $files Array containing the files to process
    */
   function __construct($base, $cacheDir, $files) {

      $hash = $this->_getHeaderHash($base, $files);
      $this->_handleHeaderHash($hash);
      $encoding = $this->_getEncoding();

      // Retrieve from cache or files
      $cacheFile = $this->_getCacheFile($hash, $encoding);
      if (!$content = $this->_getFromCache($cacheDir, $cacheFile)) {
         $content = $this->_createContent($base, $files, $cacheDir, $cacheFile);
      }

      $this->_showContent($content, $encoding);

   }


   /**
    * Returns a unique hash for the given file combination
    *
    * @access private
    * @param $base The base path of the file
    * @param $files Array containing the files to process
    * @return The created hash String
    */
   private function _getHeaderHash($base, $files) {

      $lastModified = 0;
      while (list(,$file) = each($files)) {

         $path = realpath($base . '/' . $file);
         if (substr($path, -3) != '.js') {
            header ("HTTP/1.0 403 Forbidden");
            exit;
         }

         if (substr($path, 0, strlen($base)) != $base || !file_exists($path)) {
            header ("HTTP/1.0 404 Not Found");
            exit;
         }

         $lastModified = max($lastModified, filemtime($path));
      }

      return $lastModified . '-' . md5($_GET['files']);
   }


   /**
    * Handles browser cache
    *
    * @access private
    * @param $hash The unique hash for this call
    */
   private function _handleHeaderHash($hash) {

      header ("Etag: \"" . $hash . "\"");

      if (isset($_SERVER['HTTP_IF_NONE_MATCH']) &&

      $_SERVER['HTTP_IF_NONE_MATCH'] == '"' . $hash . '"') {
         header ("HTTP/1.0 304 Not Modified");
         header ('Content-Length: 0');
         exit;

      }

   }


   /**
    * Gets the requested contents from the cache
    *
    * @access private
    * @param $cacheFile The cache file to use
    * @return boolean True on success, false on failure
    */
   private function _getFromCache($cacheDir, $cacheFile) {

      if ($content = file_get_contents($cacheDir . '/' . $cacheFile)) {
         return $content;
      }

      return false;
   }


   /**
    * Gets the available (best) encoding for file transfers
    *
    * @access private
    * @return mixed The best available encoding type or 'none'
    */
   private function _getEncoding() {

      $regex = '/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i';

      // Determine compression
      $gzip     = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
      $deflate  = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');
      $encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');

      // Check for buggy versions of Internet Explorer
      if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') &&
      preg_match($regex, $_SERVER['HTTP_USER_AGENT'], $matches)) {
         $version = floatval($matches[1]);

         if ($version < 6)
         $encoding =' none';

         if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1'))
         $encoding = 'none';
      }

      return $encoding;
   }


   /**
    * Gets the name of the cache file for the current request
    *
    * @access private
    * @param $hash The unique hash for this call
    * @param $encoding The encoding to use
    * @return String The name of the cache file for the current request
    */
   private function _getCacheFile($hash, $encoding) {
      $encoding = ($encoding != 'none') ? '.' . $encoding : '';
      return 'cache-' . $hash . '.javascript' . $encoding;
   }


   /**
    * Creates the content from the given files
    *
    * @access private
    * @param $base The base path of the file
    * @param $files Array containing the files to process
    * @param $cacheDir The cache directory to use
    * @param $cacheFile The cache file to use
    * @return String The contents created
    */
   private function _createContent($base, $files, $cacheDir, $cacheFile) {

      reset($files);

      // Create
      $content = '';
      while (list(,$file) = each($files)) {

         $path = realpath($base . '/' . $file);
         $content .= "\n\n" . file_get_contents($path);

      }

      // Write to cache
      if (is_writable($cacheDir)) {

         if ($fp = @fopen($cacheDir . '/' . $cacheFile, 'wb')) {

            fwrite($fp, $content);
            @fclose($fp);

         }

      }

      return $content;
   }


   /**
    * Shows the created content
    *
    * @access private
    * @param $content The contents to show
    * @param $encoding The encoding to use
    */
   private function _showContent($content, $encoding) {

      header("Content-Type: text/javascript");
      header('Content-Length: ' . strlen($content));

      if ($encoding != 'none') {

         $gzip = ($encoding == 'gzip') ? FORCE_GZIP : FORCE_DEFLATE;
         $content = gzencode($content, 9, $gzip);

         header("Content-Encoding: " . $encoding);
         header('Content-Length: ' . strlen($content));

      }

      header("Expires: " . gmdate('M d Y H:i:s', time() + 604800));
      die($content);

   }

}

new Combine($base, $cacheDir, $files);
?>