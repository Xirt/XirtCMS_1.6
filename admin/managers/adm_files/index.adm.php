<?php

require_once('includes/Dir.php');
require_once('includes/File.php');
require_once('includes/DirectoryTree.php');
require_once('includes/DirectoryList.php');
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

      XPage::addStylesheet('managers/adm_files/css/main.css?' . microtime());
      XPage::addScript('managers/adm_files/js/fileviewer.js?' . microtime());
      XPage::addScript('managers/adm_files/js/filetree.js?' . microtime());
      XPage::addScript('managers/adm_files/js/manager.js?' . microtime());
      XPage::addScript('../js/src/xupload.js?' . microtime());
      XInclude::plugin('slimbox');

      switch (XTools::getParam('task')) {

         /**
          * Show methods
          */
         case 'add_item':
            ContentManager::addItem();
            break;

         /**
          * Modify methods
          */
         default:
            ContentViewer::showTemplate();
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
            ContentViewer::showDirectoryTree();
            return;

         case 'show_directory':
            ContentViewer::showDirectory();
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

         case 'remove_item':
            ContentManager::removeItem();
            return;

      }

   }

}
?>