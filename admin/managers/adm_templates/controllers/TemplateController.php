<?php

/**
 * Controller for Template
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TemplateController extends XController {

   /**
    * The path to templates
    */
   const TPL_PATH = '%stemplates/%s/';


   /**
    * @var An alias for the Model for this Controller
    *
    * @access protected
    */
   protected $_template = null;


   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;
      $actions = array(
         'show', 'edit', 'edit_config', 'toggle_status', 'set_active', 'delete'
      );

      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('id', 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Template not found", E_USER_NOTICE);
            exit;

         }

      }

      $this->_template = $this->_model;

   }


   /**
    * Shows the data in the Model
    *
    * @access protected
    */
   public function show() {
   }


   /**
    * Adds the data in the Model
    *
    * @access protected
    */
   protected function add() {
      global $xCom, $xConf;

      $this->_template->set('name',   XTools::getParam('nx_name'));
      $this->_template->set('folder', XTools::getParam('nx_folder'));

      $list = new TemplatesModel();
      $list->load();

      // Validation: already exists (template folder)
      if ($list->getItemByAttribute('folder', $this->_template->folder)) {
         die($xCom->xLang->messages['creationFailure']);
      }

      // Creates template structure
      $creator = new TemplateCreator($this->_template->folder);
      $creator->execute();

      $this->_template->add();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {
      global $xCom, $xUser;

      $pages  = XTools::getParam('x_pages');
      $folder = XTools::getParam('x_folder');

      // Validation: already exists (template folder)
      //$newDir = self::_getPath($folder);
      //if ($this->_template->folder != $folder && !self::_isAvailable($newDir)) {
      //   die($xCom->xLang->messages['renameFailure']);
      //}

      // Validation: already exists (template folder)
      //$oldDir = new XDir(self::_getPath($this->folder));
      //if ($this->_template->folder != $folder && !$oldDir->rename($newDir)) {
      //   die($xCom->xLang->messages['renameFailure']);
      //}

      $this->_template->set('folder', $folder);
      $this->_template->set('pages',  sprintf('|%s|', $pages));
      $this->_template->set('name',   XTools::getParam('x_name'));

      $this->_template->save();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit_config() {

      $positions = XTools::getParam('x_positions');
      $this->_template->set('positions', sprintf('|%s|', $positions));
      $this->_template->save();

   }


   /**
    * Toggles the publication status for the template
    *
    * @access protected
    */
   protected function toggle_status() {

      // Prevents accidents
      if (!$this->_template->active) {

         $value = !intval($this->_template->published);
         $this->_template->set('published', $value);
         $this->_template->save();

      }

   }


   /**
    * Sets active status for the template
    *
    * @access protected
    */
   protected function set_active() {

      $this->_template->set('published', 1);
      $this->_template->set('active', 1);
      $this->_template->save();

   }


   /**
    * Deletes the data in the Model
    *
    * @access protected
    */
   protected function delete() {
      global $xCom, $xConf;

      // Prevents accidents
      if ($this->_template->active) {
         die($xCom->xLang->messages['noActiveRemoval']);
      }

      // Retrieves the template folder
      $folder = $this->_template->folder;
      $folder = new XDir(sprintf(self::TPL_PATH, $xConf->baseDir, $folder));

      // Attempts to remove the template folder
      if ($folder->exists() && !$folder->delete()) {
         die($xCom->xLang->messages['removalFailure']);
      }

      $this->_template->delete();

   }

}
?>