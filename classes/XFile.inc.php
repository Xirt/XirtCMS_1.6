<?php

/**
 * Class that handles file management in the filesystem
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XFile {

   /**
    * Constructor
    *
    * @param $path The location of the new file
    * @param $file The name of the new file
    */
   function __construct($path, $file) {

      $this->path = $this->_parse($path);
      $this->file = $this->path . $file;
      $this->name = basename($this->file);

   }


   /**
    * Creates the file in the filesystem
    *
    * @param $mode the value used to CHMOD the item (optional)
    * @param $content The content of the item (optional)
    * @return boolean True on success, false on failure
    */
   public function create($mode = null, $content = null) {

      if ($fp = @fopen($this->file, 'x') && $this->chmod($mode)) {

         if ((!$content || fwrite($fp, $content))) {
            return (@fclose($fp) || true);
         }

      }

      $this->unlink();
      return false;
   }


   /**
    * Renames the file
    *
    * @param $name The new name of the file
    * @return boolean True on success, false on failure
    */
   public function rename($name) {

      if (@rename($this->file, $this->path . $name)) {
         return ($this->file = $this->path . $name);
      }

      return false;
   }


   /**
    * Moves the file
    *
    * @param $path The path to the new location
    * @return boolean True on success, false on failure
    */
   public function move($path) {

      if (@rename($this->file, $path . $this->name)) {
         return ($this->file = $path . $this->name);
      }

      return false;
   }


   /**
    * Unlinks the file
    */
   public function delete() {
      return (is_file($this->file) && @unlink($this->file));
   }


   /**
    * Alternative call for unlinking files
    */
   public function unlink() {
      return $this->delete();
   }


   /**
    * Creates a directory
    *
    * @param $path The file to modify
    * @param $mode the value used to chmod the item
    * @return boolean True on success, false on failure
    */
   public function chmod($mode = null) {
      global $xConf;

      $mode = $mode ? octdec($mode) : $xConf->chmod;
      return (is_file($this->file) && @chmod($this->file, $mode));
   }


   /**
    * Returns the contents of the file
    *
    * @return String The contents of the file
    */
   public function read() {
      return file_get_contents($this->file);
   }


   /**
    * Returns the modification time of the file
    *
    * @return int The modification time as UNIX timestamp or 0 on failure
    */
   public function modified() {
      return intval(@filemtime($this->file));
   }


   /**
    * Checks the existence of the file in the filesystem
    *
    * @return boolean True on existence, false otherwhise
    */
   public function exists() {
      return is_file($this->file);
   }


   /**
    * Checks whether the file is writable
    *
    * @return boolean True if existing and writable, false otherwhise
    */
   public function writable() {
      return is_writable($this->file);
   }


   /**
    * Checks whether the file is readable
    *
    * @return boolean True if existing and readable, false otherwhise
    */
   public function readable() {
      return is_readable($this->file);
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