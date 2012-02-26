<?php

/**
 * Viewer for XirtCMS files
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentViewer {

   /**
    * Shows the main screen
    */
   public static function showTemplate() {
      global $xCom;

      $tpl = new XAdminTemplate('adm_files');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->display('main.tpl');

   }


   /**
    * Shows a directory tree as JSON object
    */
   public static function showDirectoryTree() {

      $list = new DirectoryTree();
      $list->show();

   }


   /**
    * Shows directory content as JSON object
    */
   public static function showDirectory() {

      $path = XTools::getParam('dir', './', _STRING);
      $list = new DirectoryList($path);
      $list->show();

   }


   /**
    * Shows file/directory properties as JSON object
    */
   public static function showItem() {

      if (($item = XTools::getParam('path')) && is_file($item)) {

         $item = new File(dirname($item), basename($item));
         $item->show();

      } elseif (is_dir($item)) {

         $item = new Dir($item);
         $item->show();

      }

   }

}
?>