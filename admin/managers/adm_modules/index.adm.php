<?php


/**
 * Manager for XirtCMS modules
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
            new ModulesController('ModulesModel', 'ModulesView', 'show');
            return;

         case 'show_item':
            new ModuleController('ModuleModel', 'ModuleView', 'show');
            return;

         case 'show_details':
            new ModuleController('ModuleModel', 'ModuleView', 'showDetails');
            return;


            /*
             * Modify methods
             */
         case 'add_item':
            new ModuleController('ModuleModel', null, 'add');
            return;

         case 'add_translation':
            new ModuleListController('ModuleListModel', null, 'translate');
            return;

         case 'edit_item':
            new ModuleController('ModuleModel', null, 'edit');
            new ModuleListController('ModuleListModel', null, 'edit');
            return;

         case 'edit_config':
            new ModuleListController('ModuleListModel', null, 'editConfiguration');
            return;

         case 'edit_access':
            new ModuleController('ModuleModel', null, 'editAccess');
            new ModuleListController('ModuleListModel', null, 'editAccess');
            return;

         case 'toggle_mobile':
            new ModuleController('ModuleModel', null, 'toggleMobile');
            return;

         case 'toggle_status':
            new ModuleController('ModuleModel', null, 'toggleStatus');
            return;

         case 'remove_translation':
            new ModuleController('ModuleModel', null, 'delete');
            return;

      }

   }

}
?>