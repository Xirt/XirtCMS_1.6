<?php

/**
 * Controller for a directory
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class DirectoryController extends XController {

   /**
    * Initializes the Controller
    *
    * @param $model The Model to use (optional, default null)
    * @param $view The View to use (optional, default null)
    * @param $action The action to execute (optional, default 'show')
    */
   function __construct($model = null, $view = null, $action = 'show') {
      global $xConf;

      chdir($xConf->baseDir);
      parent::__construct($model, $view, $action);

   }


   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;
      if (in_array($this->_action, array('show', 'add', 'edit', 'delete'))) {

         // Load existing data
         $this->_model->load(XTools::getParam('path', null, _STRING));
         if (!$this->_model->exists() && $this->_action != 'create') {

            trigger_error("[Controller] Directory not found", E_USER_NOTICE);
            exit;

         }

      }

   }


   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {
   }


   /**
    * Add an item to the model (upload file)
    *
    * @access protected
    */
   protected function add() {
      global $xConf;

      $xConf->showTemplate(false);

      if (array_key_exists('APC_UPLOAD_PROGRESS', $_POST)) {

         $upload = new XUpload($_POST['APC_UPLOAD_PROGRESS']);
         $upload->move('nitem_file', XTools::getParam('path', null, _STRING));

      }

   }


   /**
    * Edits the model
    *
    * @access protected
    */
   public static function edit() {
      global $xCom, $xConf;

      $oldPath = XTools::getParam('path');
      $oldName = basename($oldPath);
      $oldPath = dirname($oldPath);

      $newName = XTools::getParam('x_name');
      $newPath = XTools::getParam('x_path');

      chdir($xConf->baseDir);
      $file = new XFile($oldPath, $oldName);  // Dit werkt maar is niet logisch ?

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
    * Deletes the model
    *
    * @access protected
    */
   protected function delete() {
      $this->_model->delete();
   }

}
?>