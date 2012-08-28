<?php

/**
 * Manager for XirtCMS components
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
            new ComponentsController('ComponentsModel', 'ComponentsView', 'show');
            return;

         case 'show_item':
            new ComponentController('ComponentModel', 'ComponentView', 'show');
            return;


         /*
          * Modify methods
          */
         case 'edit_access':
            new ComponentController('ComponentModel', null, 'editAccess');
            return;

      }

   }

}
?>