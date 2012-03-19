<?php

/**
 * Manager for files within XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentManager {

   /**
    * Creates a directory
    */
   public static function createDirectory() {
      global $xCom, $xConf;

      $name = XTools::getParam('nitem_name');
      $path = XTools::getParam('path');

      chdir($xConf->baseDir);
      chdir($path);

      $dir = new XDir($path . $name);
      if (!XValidate::isSimpleChars($name) || !$dir->create()) {
         die($xCom->xLang->messages['creationFailed']);
      }

   }


   /**
    * Adds item (upload)
    */
   public static function addItem() {
      global $xConf;

      chdir($xConf->baseDir);
      $xConf->showTemplate(false);
      $path = XTools::getParam('path');

      if (array_key_exists('APC_UPLOAD_PROGRESS', $_POST)) {

         $upload = new XUpload($_POST['APC_UPLOAD_PROGRESS']);
         $upload->move('nitem_file', $path);

      }

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xCom, $xConf;


      $oldPath = XTools::getParam('path');
      $oldName = basename($oldPath);
      $oldPath = dirname($oldPath);

      $newName = XTools::getParam('x_name');
      $newPath = XTools::getParam('x_path');

      chdir($xConf->baseDir);
      $file = new XFile($oldPath, $oldName);

      if ($oldPath != $newPath || $oldName != $newName) {

         // Check goal location
         if (file_exists($newPath . $newName)) {
            die($xCom->xLang->messages['fileExists']);
         }

         // Attempt to move file
         if ($oldPath != $newPath && !$file->move($newPath)) {
            die($xCom->xLang->messages['noRelocate']);
         }

         // Attempt to rename file
         if ($oldName != $newName && !$file->rename($newName)) {
            die($xCom->xLang->messages['noRename']);
         }

      }

   }


   /**
    * Removes item
    */
   public static function removeItem() {
      global $xCom, $xConf;

      chdir($xConf->baseDir);

      if (($item = XTools::getParam('path')) && is_file($item)) {

         $item = new XFile(dirname($item), basename($item));
         $item->unlink();

      } elseif (is_dir($item)) {

         $item = new XDir($item);
         $item->unlink();

      }

   }

}
?>