<?php

/**
 * Controller for a list of XirtCMS Modules (translations)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ModuleListController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $actions = array(
         'show', 'translate', 'edit', 'editConfiguration', 'editAccess'
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('xid', 1, _INT));
         if (!isset(current($this->_model->toArray())->id)) {
            trigger_error("[Controller] Module not found", E_USER_NOTICE);
         }

      }

   }


   /**
    * Shows the data in the Model
    *
    * @access protected
    */
   public function show() {
   }


   /**
    * Translates the data in the Model
    *
    * @access protected
    */
   protected function translate() {
      global $xUser;

      // Create from best translation
      $iso = XTools::getParam('language');
      foreach ($this->_model->toArray() as $candidate) {

         if ($candidate->language != $iso) {

            $item = new ModuleModel();
            $item->load($candidate->id);

            $item->set('id',          null, true);
            $item->set('language',    $iso);
            $item->set('published',   0);
            $item->set('name',        $item->name . '*');

            $item->add();

         }

      }

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {

      if (XTools::getParam('affect_all')) {

         $list = $this->_model->toArray();

         $type = reset($list)->type;
         $config = XModule::getConfiguration($type);

         foreach ($list as $module) {

            foreach ($config as $name => $details) {

               $value = XTools::getParam('xvar_' . $name);
               $module->config->$name = trim($value);

            }

         }

         $this->_model->set('name', XTools::getParam('x_name'));
         $this->_model->save();

      }

   }


   /**
    * Modifies the configuration data in the Model
    *
    * @access protected
    */
   protected function editConfiguration() {

      $this->_model->set('position', XTools::getParam('x_position'));
      $this->_model->set('ordering', XTools::getParam('x_ordering'));
      $this->_model->set('pages', XTools::getParam('x_pages'));
      $this->_model->save();

   }


   /**
    * Modifies the access data in the Model
    *
    * @access protected
    */
   protected function editAccess() {

      if (XTools::getParam('affect_all')) {

         $this->_model->set('access_min', XTools::getParam('access_min', 0, _INT));
         $this->_model->set('access_max', XTools::getParam('access_max', 0, _INT));
         $this->_model->save();

      }

   }

}
?>