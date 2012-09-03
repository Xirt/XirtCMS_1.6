<?php


/**
 * Manager for XirtCMS content categories
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

         case 'show_content_list':
            new CategoriesController('CategoriesModel', 'CategoriesView', 'show');
            return;

         case 'show_item':
         case 'show_details':
            new CategoryController('CategoryModel', 'CategoryView', 'show');
            return;

         case 'add_item':
            new CategoryController('CategoryModel', null, 'add');
            return;

         case 'add_translation':
            new CategoryListController('CategoryListModel', null, 'translate');
            return;

         case 'edit_item':
            new CategoryController('CategoryModel', null, 'edit');
            new CategoryListController('CategoryListModel', null, 'edit');
            return;

         case 'edit_config':
            ContentManager::editConfiguration();
            return;

         case 'edit_access':
            new CategoryController('CategoryModel', null, 'editAccess');
            new CategoryListController('CategoryListModel', null, 'editAccess');
            return;

         case 'move_down':
            new CategoriesController('CategoriesModel', null, 'moveDown');
            return;

         case 'move_up':
            new CategoriesController('CategoriesModel', null, 'moveUp');
            return;

         case 'toggle_sitemap':
            new CategoryController('CategoryModel', null, 'toggleSitemap');
            return;

         case 'toggle_mobile':
            new CategoryController('CategoryModel', null, 'toggleMobile');
            return;

         case 'toggle_status':
            new CategoryController('CategoryModel', null, 'toggleStatus');
            return;

         case 'remove_translation':
            new CategoryListController('CategoryListModel', null, 'delete');
            return;

      }

   }

}
?>