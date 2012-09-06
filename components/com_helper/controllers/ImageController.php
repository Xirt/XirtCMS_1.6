<?php

/**
 * Controller for handling images
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ImageController extends XController {

   /**
    * Creates a thumbnail from GET/POST data
    *
    * @access protected
    */
   protected function thumbnail() {
      new Thumbnail();
   }

}
?>