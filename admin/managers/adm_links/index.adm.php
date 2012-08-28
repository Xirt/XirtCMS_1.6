<?php

/**
 * Manager for XirtCMS links
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {
      new PanelController('PanelModel', 'PanelView', 'show');
   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         /*
          * View methods
          */
         case 'show_content_list':
            new LinksController('LinksModel', 'LinksView', 'show');
            return;

         case 'show_item':
            new LinkController('LinkModel', 'LinkView', 'show');
            return;


            /*
             * Modify methods
             */
         case 'add_item':
            new LinkController('LinkModel', null, 'add');
            return;

         case 'edit_item':
            new LinkController('LinkModel', null, 'edit');
            return;

         case 'remove_item':
            new LinkController('LinkModel', null, 'delete');
            return;
      }

   }

}
?>