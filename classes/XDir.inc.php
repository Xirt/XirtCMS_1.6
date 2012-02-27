<?php

/**
 * Class that handles directory management in the filesystem
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XDir {

   /**
    * Constructor
    *
    * @param $path The location of the new file
    */
   function __construct($path) {

      $this->path = $this->_parse($path);
      $this->name = basename($this->path);

   }


   /**
    * Creates the directory in the filesystem
    *
    * @param $mode The value used to CHMOD the item (optional)
    * @param $recursive Toggles recursive creation of the directory
    * @return boolean True on success, false on failure
    */
   public function create($mode = null, $recursive = false) {
      global $xConf;

      $mode = $mode ? octdec($mode) : $xConf->chmod;
      if (!file_exists($this->path) && mkdir($this->path, $mode, $recursive)) {
         return true;
      }

      return false;
   }


   /**
    * Renames the directory
    *
    * @param $path The new name of the directory
    * @return boolean True on success, false on failure
    */
   public function rename($path) {

      if (@rename($this->path, $path)) {
         return ($this->path = $path);
      }

      return false;
   }


   /**
    * Moves the directory
    *
    * @param $path The path to the new location
    * @return boolean True on success, false on failure
    */
   public function move($path) {

      if (@rename($this->path, $path . basename($this->path))) {
         return ($this->path = $path . basename($this->path));
      }

      return false;
   }


   /**
    * Unlinks the directory and contents
    */
   public function delete() {
      return (is_dir($this->path) && @$this->_delete($this->path));
   }


   /**
    * Recursively unlink a file or directory
    *
    * @param $path The path to the current file or directory to unlink
    */
   private function _delete($path) {

      if (is_file($path)) {
         return @unlink($path);
      }

      foreach(glob(rtrim($path, '/') . '/*') as $child) {
         $this->_delete($child);
      }

      return @rmdir($path);
   }


   /**
    * Alternative call for unlinking files
    */
   public function unlink() {
      return $this->delete();
   }


   /**
    * Returns the structure of a directory as an Array
    *
    * @param $showFiles Toggles indexing of files (optional, default: true)
    * @param $doDeepScan Toggles depth scanning (optional, default: false)
    * @return Array containing all found files / directories
    */
   public function summarize($showFiles = true, $doDeepScan = false) {
      return $this->_summarize(substr($this->path, 0, -1), $showFiles, $doDeepScan);
   }


   /**
    * Returns the structure of a directory as an Array
    *
    * @access private
    * @param $path The path to analyze
    * @param $showFiles Toggles indexing of files
    * @param $doDeepScan Toggles depth scanning
    * @return Array containing all found files / directories
    */
   private function _summarize($path, $showFiles, $doDeepScan) {

      $paths = $files = array();
      foreach (array_diff(scandir($path), array('.', '..')) as $item) {

         $current = sprintf('%s/%s', $path, $item);

         if (is_file($current) && $showFiles) {
            $files[] = $current;
         } elseif (is_dir($current)) {
            $paths[] = $current . '/';
         }

         if ($doDeepScan && is_dir($current)) {

            $deepPaths = $this->_summarize($current, $showFiles, $doDeepScan);
            $paths = array_merge($deepPaths, $paths);

         }

      }

      sort($paths);
      sort($files);
      return array_merge($paths, $files);
   }


   /**
    * Creates a directory
    *
    * @param $mode the value used to chmod the item
    * @param $doDeepScan Toggles chmodding of underlying items
    * @return boolean True on success, false on failure
    */
   public function chmod($mode = null, $doDeepScan = false) {
      global $xConf;

      $mode = $mode ? octdec($mode) : $xConf->chmod;

      if (is_dir($this->path) && @chmod($this->path, $mode)) {

         if ($doDeepScan) {

            // Recursion through filesystem
            $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->path),
            RecursiveIteratorIterator::SELF_FIRST
            );

            foreach($iterator as $path) {

               if (!@chmod($path, $mode)) {
                  trigger_error('Chmod failure: ' . $path, E_USER_WARNING);
               }

            }

         }

         return true;
      }


      return false;
   }


   /**
    * Returns the modification time of the directory
    *
    * @return int The modification time as UNIX timestamp or 0 on failure
    */
   public function modified() {
      return intval(@filemtime($this->path));
   }


   /**
    * Checks the existence of the directory in the filesystem
    *
    * @return boolean True on existence, false otherwhise
    */
   public function exists() {
      return is_dir($this->path);
   }


   /**
    * Checks whether the directory is writable
    *
    * @return boolean True if existing and writable, false otherwhise
    */
   public function writable() {
      return is_writable($this->path);
   }


   /**
    * Checks whether the directory is readable
    *
    * @return boolean True if existing and readable, false otherwhise
    */
   public function readable() {
      return is_readable($this->path);
   }


   /**
    * Returns the given path with slashes and trailing slash
    *
    * @param $path The path to parse
    * @return String The path with slashes and trailing slash
    */
   private function _parse(&$path) {
      return str_replace('//', '/', str_replace('\\', '/', $path) . '/');
   }

}
?>