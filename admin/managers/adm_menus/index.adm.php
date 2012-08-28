<?php

/**
 * Manager for XirtCMS Menus
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
            new MenusController('MenusModel', 'MenusView', 'show');
            return;

         case 'show_item':
            new MenuController('MenuModel', 'MenuView', 'show');
            return;


         /*
          * Modify methods
          */
         case 'add_item':
            new MenuController('MenuModel', null, 'add');
            return;

         case 'add_translation':
            new MenuListController('MenuListModel', null, 'translate');
            return;

         case 'edit_item':
            new MenuController('MenuModel', null, 'edit');
            return;

         case 'move_up':
            new MenusController('MenusModel', null, 'moveUp');
            return;

         case 'move_down':
            new MenusController('MenusModel', null, 'moveDown');
            return;

         case 'toggle_sitemap':
            new MenuController('MenuModel', null, 'toggleSitemap');
            return;

         case 'toggle_mobile':
            new MenuController('MenuModel', null, 'toggleMobile');
            return;

         case 'remove_translation':
            new MenuController('MenuModel', null, 'delete');
            return;

      }

   }

}
?>