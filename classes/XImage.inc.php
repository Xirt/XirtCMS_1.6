<?php

/**
 * Class for image creation and modification
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XImage {

   /**
    * @var The source path of the image
    */
   var $src = null;


   /**
    * @var The current image stream
    */
   var $img = null;


   /**
    * Constructor
    *
    * @param $img The resource of the image (optional)
    */
   function __construct($img = null) {

      if (function_exists('gd_info') && $info = gd_info()) {

         if (intval(preg_replace('%[^0-9\.]%', '', $info['GD Version'])) > 1) {
            return ($this->img = $img);
         }

      }

      trigger_error("[XImage] GD2 not available.", E_USER_WARNING);

   }


   /**
    * Destructor
    */
   function __destruct() {

      isset($this->img) ? @imagedestroy($this->img) : null;

   }


   /**
    * Creates a new image (true color)
    *
    * @param $width Int with the width of the image (optional, default: 500px)
    * @param $height Int with the height of the image (optional, default: 500px)
    * @return boolean True on succes, false on failure
    */
   public function create($width = 500, $height = 500, $color = null) {

      if ($this->img = @imagecreatetruecolor($width, $height)) {

         if (is_null($color) || !imagefill($this->img, 0, 0, $color)) {

            $color = imagecolorallocatealpha($this->img, 255, 255, 255, 127);
            @imagefill($this->img, 0, 0, $color);

         }

         return true;

      }

      return false;
   }


   /**
    * Loads image from a file
    *
    * @param $src String with path to the file
    * @return boolean True on succes, false on failure
    */
   public function load($src) {

      if (!$this->img = imagecreatefromstring(file_get_contents($src))) {
         trigger_error("[XImage] Loading failed.", E_USER_NOTICE);
         return false;
      }

      return ($this->src = $src);
   }


   /**
    * Resizes the current image
    *
    * @param $width Int with the new width of the image
    * @param $height Int with the new width of the image
    */
   public function resize($width, $height) {

      $props = $this->getProperties();
      $scaleX = $props['width'] / $width;
      $scaleY = $props['height'] / $height;

      $offsetX = $offsetY = 0;

      if ($scaleY > $scaleX) {

         $nWidth = round($props['width'] * (1 / $scaleX));
         $nHeight = round($props['height'] * (1 / $scaleX));
         $offsetY = -floor(($nHeight - $height) / 2);

      } else {

         $nWidth = round($props['width'] * (1 / $scaleY));
         $nHeight = round($props['height'] * (1 / $scaleY));
         $offsetX = -floor(($nWidth - $width) / 2);

      }

      $new = new XImage();
      $new->create($width, $height);

      imagecopyresampled(
      $new->img, $this->img, $offsetX, $offsetY, 0, 0,
      $nWidth, $nHeight, $props['width'], $props['height']
      );

      $this->img = $new->img;
      unset($new->img);

   }


   /**
    * Merges the given image into the current one at the given position
    *
    * @param $src The image to insert
    * @param $x The x-location to insert the given image
    * @param $y The y-location to insert the given image
    */
   public function merge($src, $x = 0, $y = 0) {

      $props = $src->getProperties();
      $width  = $props['width'];
      $height = $props['height'];

      imagecopy($this->img, $src->img, $x, $y, 0, 0, $width, $height);

   }


   /**
    * Saved the current image
    *
    * @param $file String with path to destination file (optional, default: NULL)
    * @param $quality Int with preferred quality (1 - 100)
    * @param $type String defined by IMAGETYPE constants
    * @return boolean True on succes, false on failure
    */
   public function save($file = null, $quality = 100, $type = IMAGETYPE_JPEG) {

      switch ($type) {

         case IMAGETYPE_JPEG:
            imagejpeg($this->img, $file, $quality);
            break;

         case IMAGETYPE_PNG:
            imagesavealpha($this->img, true);
            imagepng($this->img, $file, round(9 - ($quality / 100 * 9)));
            break;

         default:
            trigger_error("[XImage] Unknown image type.", E_USER_NOTICE);
            return false;
            break;
      }

      return true;
   }


   /**
    * Returns the properties of the image
    *
    * @param $src String with path to the file to inspect (optional)
    * @return mixed Null on failure, Array with properties on success
    */
   public function getProperties($src = null) {

      $src = isset($src) ? $src : $this->src;
      if ($src && list($width, $height, $mime) = @getimagesize($src)) {
         return array('width' => $width, 'height' => $height, 'mime' => $mime);
      }

      return null;
   }

}
?>