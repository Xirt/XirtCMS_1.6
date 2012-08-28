<?php

/**
 * Manager for XirtCMS usergroups
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
            new UsergroupsController('UsergroupsModel', 'UsergroupsView', 'show');
            return;

         case 'show_item':
            new UsergroupController('UsergroupModel', 'UsergroupView', 'show');
            return;

         /*
          * Modify methods
          */
         case 'add_item':
            new UsergroupController('UsergroupModel', null, 'add');
            return;

         case 'add_translation':
            new UsergroupListController('UsergroupListModel', null, 'translate');
            return;

         case 'edit_item':
            new UsergroupController('UsergroupModel', null, 'edit');
            new UsergroupListController('UsergroupListModel', null, 'edit');
            return;

         case 'remove_translation':
            new UsergroupController('UsergroupModel', null, 'delete');
            return;

      }

   }

}
?>