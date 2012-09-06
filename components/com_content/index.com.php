<?php

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

      switch (XTools::getParam('task')) {

         case 'show_print':
            new PanelController('ContentModel', 'PrintView', 'show');
            break;

         case 'show_pdf':
            new PanelController('ContentModel', 'PDFView', 'show');
            break;

         default:
            new PanelController('ContentModel', 'NormalView', 'show');
            break;

      }

   }


   /**
    * Shows the AJAX content
    */
   function showAJAX() {

      switch (XTools::getParam('task')) {

         case 'send_mail':
            new MailController('ContentModel', null, 'send');
            break;

      }

   }

}
?>