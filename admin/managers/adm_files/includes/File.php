<?php

/**
 * Object containing details about a file
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class File extends XFile {

   /**
    * @var The type of the instance
    */
   var $type = null;


   /**
    * Initializes object with details about the file / directory
    *
    * @param $path The path to the file
    * @param $file The name of the file
    */
   function __construct($path, $file) {

      parent::__construct($path, $file);
      $this->_init();

   }


   /**
    * Initializes the instance for a file
    *
    * @param $path The path to the file
    */
   private function _init() {

      $this->type       = $this->_getType();
      $this->writable   = is_writable($this->file);
      $this->dimensions = $this->_getDimensions();
      $this->chmod      = $this->getPermissions();

   }


   /**
    * Returns the chmod of the item
    *
    * @return Int The current CHMOD of the item
    */
   public function getPermissions() {

      if (substr(PHP_OS, 0, 3) == 'WIN') {
         return -1;
      }

      return substr(decoct(fileperms($this->path)), -3);
   }


   /**
    * Returns the dimenions for this image (if the instance is an image)
    *
    * @access private
    * @return String The dimensions for this image or null
    */
   private function _getDimensions() {
      global $xCom;

      if ($this->type != 'image' || !($img = @getimagesize($this->file))) {
         return null;
      }

      return sprintf($xCom->xLang->misc['dimensions'], $img[0], $img[1]);
   }


   /**
    * Returns the type for this file (or unknown)
    *
    * @access private
    * @return String The dimensions for this image or null
    */
   private function _getType() {

      $extensions = array (
         'archive'  => array('7z', 'deb', 'gz', 'pkg', 'rar', 'gz', 'zip'),
         'cer'      => array('cer', 'csr'),
         'document' => array('doc', 'docx', 'odt'),
         'flash'    => array('flv', 'swf'),
         'pdf'      => array('pdf'),
         'php'      => array('php', 'php3', 'phtml'),
         'txt'      => array(
            'asp', 'htm', 'html', 'js', 'jsp', 'rss', 'xhtml', 'txt', 'css',
            'html', 'csv', 'js'
         ),
         'music'    => array(
            'aac', 'aif', 'iff', 'm3u', 'mid', 'mp3', 'mpa', 'ra', 'wav', 'wma'
         ),
         'sheet'    => array('xls', 'xlsx', 'ods'),
         'video'    => array(
            'asf', 'asx', 'avi', 'mov', 'mp4', 'mpg', 'rm', 'vob', 'wmv'
         ),
         'image'    => array(
            'bmp', 'gif', 'png', 'jpg'
         )
      );

      $ext = array_pop(explode('.', $this->name));

      foreach ($extensions as $type => $associates) {

         if (in_array($ext, $associates)) {
            return $type;
         }

      }

      return 'unknown';
   }


   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this);
   }


   /**
    * Shows list as JSON Object
    */
   public function show() {

      header('Content-type: application/x-json');
      die($this->encode());

   }

}
?>