<?php

require_once('includes/Dir.php');
require_once('includes/File.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for files in the XirtCMS directory
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

      switch (XTools::getParam('task')) {

         /**
          * Show methods
          */
         case 'add_file':
            new DirectoryController('DirectoryModel', null, 'add');
            break;

         /**
          * Modify methods
          */
         default:
            new PanelController('PanelModel', 'PanelView', 'show');
            break;

      }

   }

   /**
    * Handles any AJAX requests
    */
   function showAjax() {
      global $xConf;

      chdir($xConf->baseDir);

      switch (XTools::getParam('task')) {

         /**
          * Show methods
          */
         case 'show_tree':
            new TreeController('TreeModel', 'TreeView', 'show');
            return;

         case 'show_directory':
            new DirectoryListController('DirectoryListModel', 'ListView', 'show');
            return;

         case 'show_item':
            ContentViewer::showItem();
            return;

         /**
          * Modify methods
          */
         case 'create_directory':
            ContentManager::createDirectory();
            break;

         case 'edit_item':
            ContentManager::editItem();
            return;

         case 'delete_file':
            new FileController('FileModel', null, 'delete');
            return;

         case 'delete_folder':
            new DirectoryController('DirectoryModel', null, 'delete');
            return;

      }

   }

}
?>