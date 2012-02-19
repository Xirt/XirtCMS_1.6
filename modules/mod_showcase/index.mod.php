<?php

XInclude::plugin('slimbox');

/**
 * Shows a collection of images using Slimbox (a Lightbox clone).
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_showcase extends XModule {

   /**
    * @var The path for thumbnail caching
    */
   const PATH_CACHE = "cache/mod_showcase/";


   /**
    * Handles any normal requests
    */
   function showNormal() {

      // Create cache
      $cache = new XDir(self::PATH_CACHE);
      $cache->create();

      // Show template
      $tpl = new XTemplate($this->_location());
      $tpl->assign('id',     rand());
      $tpl->assign('xConf',  $this->xConf);
      $tpl->assign('images', $this->_getImageList());
      $tpl->display('template.tpl');

   }


   /**
    * Returns a list with all thumbnail / original combinations
    *
    * @access private
    * @return Array with key/value paris of thumbnails/originals
    */
   private function _getImageList() {

      $list = array();
      $extensions = explode('|', $this->xConf->ext);

      foreach ($this->_getImages() as $file) {

         // Check for existing thumbnails
         if ($this->xConf->prefix_thumb) {

            // Postfix of image / thunbmail
            $postfix = substr($file, strlen($this->xConf->prefix_ori));
            $thumbnail = $this->xConf->prefix_thumb . $postfix;


            // Check for existing thumbnail (same extension)
            if (file_exists($this->xConf->folder . $thumbnail)) {

               $list[$this->xConf->folder . $thumbnail] = $file;
               continue;

            }

            // Otherwhise look for alternative
            $extension = substr($postfix, -3);
            $name = substr($postfix, 0, -3);

            foreach ($extensions as $ext) {

               $thumbnail = $this->xConf->prefix_thumb . $name . $extension;

               if (file_exists($this->xConf->folder . $thumbnail)) {

                  $list[$this->xConf->folder . $thumbnail] = $file;
                  continue 2;

               }

            }

         }

         // Or create a new thumbnail
         $list[$this->_createThumbnail($this->xConf->folder . $file)] = $file;

      }

      return $list;
   }


   /**
    * Creates a thumbnail (if non existent) and returns its path
    *
    * @access private
    * @param $image String with the path to the image
    * @return String The path to the thumbnail
    */
   private function _createThumbnail($image) {

      $item = sprintf("%s.jpg", md5($image));
      $cached = self::PATH_CACHE . $item;

      if (!file_exists($cached)) {

         if (!$size = abs($this->xConf->thumb_size)) {
            $size = 100;
         }

         // Create thumbnail
         $img = new XImage();
         $img->load($image);
         $img->resize($size, $size);
         $img->save($cached);

         // Chmod thumbnail
         $img = new XFile(self::PATH_CACHE, $item);
         $img->chmod();

      }

      return $cached;
   }


   /**
    * Returns all images for this instance
    *
    * @access private
    * @return Array containing names of the requested images
    */
   private function _getImages() {
      global $xConf;

      $list       = array();
      $extensions = explode('|', $this->xConf->ext);
      $path       = $xConf->baseDir . $this->xConf->folder;

      if ($dh = opendir($path)) {

         while (false !== ($file = readdir($dh))) {

            // Skip system paths
            if (in_array($file, array('.', '..'))) {
               continue;
            }

            // Check for required thumbnail prefix
            if ($this->xConf->prefix_thumb) {

               if (strpos($file, $this->xConf->prefix_thumb) === 0) {
                  continue;
               }

            }

            // Check for required original prefix
            if ($this->xConf->prefix_ori) {

               if (strpos($file, $this->xConf->prefix_ori) !== 0) {
                  continue;
               }

            }

            // Check for required extension
            $ext = pathinfo($path . $file, PATHINFO_EXTENSION);
            if (!in_array($ext, $extensions)) {
               continue;
            }

            $list[] = $file;
         }

         @closedir($dh);
      }

      // Limit the list
      if (count($list) > $this->xConf->amount && shuffle($list)) {
         return array_slice($list, 0, $this->xConf->amount);
      }

      return $list;
   }

}
?>