<?php
/**
 * Thumbnail creations script for XirtCMS file manager
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010
 * @package    XirtCMS
 */

/**
 * The X / Y (width / height) dimensions of the thumbnail
 */
define("THUMB_X", 32);
define("THUMB_Y", 32);


/*
 * Actual script - do not edit below this comment
 */

// Get the XirtCMS classes
chdir('./../../../');
require_once('./classes/XTools.inc.php');
require_once('./classes/XImage.inc.php');

// Get requested image
$src = XTools::getParam('img');

header("Content-type: image/png");
$img = new XImage();

if ($img->load($src)) {

   $props = $img->getProperties();
   if (!$props || $props['width'] < THUMB_X || $props['height'] < THUMB_Y) {

      $offsetX = round((THUMB_X - $props['width']) / 2);
      $offsetY = round((THUMB_Y - $props['height']) / 2);

      $thumb = new XImage();
      $thumb->create(THUMB_X, THUMB_Y);
      $thumb->merge($img, $offsetX, $offsetY);
      $thumb->save(null, 100, IMAGETYPE_PNG);

   } else {

      $img->resize(THUMB_X, THUMB_Y);
      $img->save(null, 100, IMAGETYPE_PNG);

      // wodt nog zwart!

   }

}
?>
