<?php

/**
 * Manager for XirtCMS menu items
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
            new MenuItemsController('MenuItemsModel', 'MenuItemsView', 'show');
            return;

         case 'show_item':
         case 'show_details':
            new MenuItemController('MenuItemModel', 'MenuItemView', 'show');
            return;


         /*
          * Modify methods
          */
         case 'add_item':
            new MenuItemController('MenuItemModel', null, 'add');
            return;

         case 'add_translation':
            new MenuItemListController('MenuItemListModel', null, 'translate');
            return;

         case 'edit_item':
            new MenuItemController('MenuItemModel', null, 'edit');
            new MenuItemListController('MenuItemListModel', null, 'edit');
            return;

         case 'edit_config':
            new MenuItemController('MenuItemModel', null, 'editConfiguration');
            new MenuItemListController('MenuItemListModel', null, 'editConfiguration');
            return;

         case 'edit_access':
            new MenuItemController('MenuItemModel', null, 'editAccess');
            new MenuItemListController('MenuItemListModel', null, 'editAccess');
            return;

         case 'move_down':
            new MenuItemsController('MenuItemsModel', null, 'moveDown');
            return;

         case 'move_up':
            new MenuItemsController('MenuItemsModel', null, 'moveUp');
            return;

         case 'toggle_home':
            new MenuItemsController('MenuItemsModel', null, 'toggleHome');
            return;

         case 'toggle_sitemap':
            new MenuItemController('MenuItemModel', null, 'toggleSitemap');
            return;

         case 'toggle_mobile':
            new MenuItemController('MenuItemModel', null, 'toggleMobile');
            return;

         case 'toggle_status':
            new MenuItemController('MenuItemModel', null, 'toggleStatus');
            return;

         case 'remove_translation':
            //new MenuItemController('MenuItemModel', null, 'remove');
            return;

      }

   }

}
?>