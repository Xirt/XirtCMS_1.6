<?php

require_once('includes/Mail.php');
require_once('includes/Viewer.php');
require_once('includes/Content.php');
require_once('includes/Template.php');

/**
 * Default component to show content items
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        Viewer
 */
class Component extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      if (!$item = $this->_getContentItem()) {
         return Xirt::pageNotFound();
      }

      switch (XTools::getParam('task')) {

         case 'show_print':
            Viewer::showPrintVersion($item);
            break;

         case 'show_pdf':
            Viewer::showPDFVersion($item);
            break;

         default:
            Viewer::showContent($item);
            break;

      }

   }


   /**
    * Shows the AJAX content
    */
   function showAJAX() {
      global $xConf;

      if (!$item = $this->_getContentItem()) {
         return Xirt::pageNotFound();
      }

      switch (XTools::getParam('task')) {

         case 'send_mail':
            $mail = new Mail($item);
            $mail->send();
            break;

      }

   }


   /**
    * Returns the requested content item
    *
    * @access private
    * @return mixed ContentItem on success,  null failure
    */
   private function _getContentItem() {

      $item = new ContentItem();

      if (!$item->load(XTools::getParam('id', 0, _INT))) {
         return null;
      }

      return $item;
   }

}
?>
