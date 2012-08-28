<?php

/**
 * Controller for XirtCMS Module
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ModuleController extends XController {

   /**
    * @var String with the location of the module files
    */
   const PATH_MODULE = "%s/modules/%s/";

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $actions = array(
         'show', 'showDetails', 'edit', 'editAccess',
         'toggleMobile', 'toggleStatus', 'delete'
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('id', 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Module not found", E_USER_NOTICE);
            exit;

         }

      }

   }


   /**
    * Shows the data in the Model
    *
    * @access protected
    */
   public function show() {
      $this->_model->set('config', '', true);
   }


   /**
    * Shows the data in the Model
    *
    * @access protected
    */
   public function showDetails() {

      $this->_model->set('ordering', null, true);
      $this->_model->set('position', null, true);
      $this->_model->set('pages', null, true);
      $this->_model->setConfiguration();

   }


   /**
    * Adds the data in the Model
    *
    * @access protected
    */
   protected function add() {
      global $xConf;

      $list = new ModulesModel();
      $this->_model->set('xid',      $list->getMaximum() + 1);
      $this->_model->set('type',     XTools::getParam('nx_type'));
      $this->_model->set('name',     XTools::getParam('nx_name'));
      $this->_model->set('language', XTools::getParam('nx_language'));

      $path = sprintf(self::PATH_MODULE, $xConf->baseDir, $this->_model->type);
      $file = new XFile($path, 'index.mod.xml');

      if ($file->readable()) {

         $this->_model->resetConfiguration();
         $this->_model->add();

      }

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {

      if (!XTools::getParam('affect_all')) {

         $type = $this->_model->type;
         $config = XModule::getConfiguration($type);

         foreach ($config as $name => $details) {

            $value = XTools::getParam('xvar_' . $name);
            $this->_model->config->$name = trim($value);

         }

         $this->_model->set('name', XTools::getParam('x_name'));
         $this->_model->save();

      }

   }


   /**
    * Modifies the access data in the Model
    *
    * @access protected
    */
   protected function editAccess() {

      if (!XTools::getParam('affect_all')) {

         $this->_model->set('access_min', XTools::getParam('access_min', 0, _INT));
         $this->_model->set('access_max', XTools::getParam('access_max', 0, _INT));
         $this->_model->save();

      }

   }


   /**
    * Toggles the mobile status for the Model
    *
    * @access protected
    */
   protected function toggleMobile() {

      $value = !intval($this->_model->mobile);
      $this->_model->set('mobile', $value);
      $this->_model->save();

   }


   /**
    * Toggles the publication status for the Model
    *
    * @access protected
    */
   protected function toggleStatus() {

      $value = !intval($this->_model->published);
      $this->_model->set('published', $value);
      $this->_model->save();

   }


   /**
    * Deletes the data in the Model
    *
    * @access protected
    */
   protected function delete() {
      $this->_model->delete();
   }

}
?>