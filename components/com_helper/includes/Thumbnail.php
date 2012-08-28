<?php

/**
 * Creates a thumbnail from an original image (using cache)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package	  XirtCMS
 */
class Thumbnail {

   /**
    * @var The default width of thumbnails
    */
   const WIDTH = 100;


   /**
    * @var The default height of thumbnails
    */
   const HEIGHT = 100;


   /**
    * @var The default caching location
    */
   const LOCATION = "cache/thumbs/";


   /**
    * The time (in seconds) before the cache items expire
    */
   const DURATION = 1800;


   /**
    * Constructor
    */
   function __construct() {
      global $xConf;

      $file  = XTools::getParam('src');
      $sizeX = XTools::getParam('x', self::WIDTH, _INT);
      $sizeY = XTools::getParam('y', self::HEIGHT, _INT);

      chdir($xConf->baseDir);
      $cache = new XDir(self::LOCATION);
      $cacheFile = new XFile(self::LOCATION, md5($file) . '.jpg');

      /// Create cache
      if ((!$cache->exists() && !$cache->create()) || !$cache->writable()) {
         trigger_error("Could not cache thumbnails", E_USER_WARNING);
      }

      // Create thumbnail
      if (time() - $cacheFile->modified() > self::DURATION) {
         $this->_create($file, $cacheFile, $sizeX, $sizeY);
      }

      header('Content-Type: image/jpg');
      die($cacheFile->read());

   }


   /**
    * Creates a thumbnail in the cache
    *
    * @access private
    * @param $src The path to the source image
    * @param $cacheFile The path to the destination image (cache)
    * @param $sizeX The width of the thumbnail
    * @param $sizeY The height of the thumbnail
    */
   private function _create($src, $cacheFile, $sizeX, $sizeY) {

      $img = new XImage();
      $img->load($src);
      $img->resize($sizeX, $sizeY);
      $img->save($cacheFile->file);
      $cacheFile->chmod();

   }

}
?>