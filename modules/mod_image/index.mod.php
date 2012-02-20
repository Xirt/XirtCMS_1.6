<?php

/**
 * Shows a static, dynamic or slideshow image
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_image extends XModule {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      $list = array();
      $extraClass = null;
      $extraScript = false;

      // Toggle inclusion of JavaScript
      if (!defined('x-mod-image')) {
         $extraScript = define('x-mod-image', 1);
      }

      // Add classes for slideshows
      if ($this->xConf->show_type == 2) {
         $extraClass = 'x-mod-image-slideshow';
      }

      // Create URL (optional)
      if (($url = $this->xConf->link) && $this->xConf->show_link) {
         $url = XTools::createLink($url, null, $this->xConf->alt);
      }

      // Show template
      $tpl = new XTemplate($this->_location());
      $tpl->assign('url',    $url);
      $tpl->assign('class',  $extraClass);
      $tpl->assign('xConf',  $this->xConf);
      $tpl->assign('script', $extraScript);
      $tpl->assign('images', $this->_getImageList());
      $tpl->display('templates/template.tpl');

   }


   /**
    * Returns a list with all selected images
    *
    * @access private
    * @return Array with all selected images
    */
   private function _getImageList() {

      switch ($this->xConf->show_type) {

         case 0:
            return $this->_showImage();
            break;

         case 1:
            return $this->_showRandomImage();
            break;

         case 2:
            return $this->_getImages();
            break;

      }

   }


   /**
    * Returns a static image for this instance
    *
    * @access private
    * @return Array containing the relative location of the image
    */
   private function _showImage() {
      global $xConf, $xPage;

      // Path & filename
      $cId       = $xPage->cId;
      $prefix    = $this->xConf->prefix;
      $extension = $this->xConf->ext;
      $path      = $xConf->baseDir . $this->xConf->folder;
      $file      = sprintf('%s%d.%s', $prefix, $cId, $extension);

      if (!file_exists($path . $file)) {
         return array($this->xConf->default);
      }

      return array($file);
   }


   /**
    * Returns a random image for this instance
    *
    * @access private
    * @return Array containing the relative location of the image
    */
   private function _showRandomImage() {
      global $xConf;

      if ($list = $this->_getImages()) {
         return array($list[array_rand($list)]);
      }

      return array($this->xConf->default);
   }


   /**
    * Returns all images for this instance
    *
    * @access private
    * @return Array containing the relative locations of all images
    */
   private function _getImages() {
      global $xConf;

      $list       = array();
      $prefix     = $this->xConf->prefix;
      $extensions = explode('|', $this->xConf->ext);
      $path       = $xConf->baseDir . $this->xConf->folder;

      if ($dh = opendir($path)) {

         while (false !== ($file = readdir($dh))) {

            // Skip system paths
            if (in_array($file, array('.', '..'))) {
               continue;
            }

            // Check for required prefix
            if ($prefix && strpos($file, $prefix) !== 0) {
               continue;
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

      return $list;
   }

}
?>