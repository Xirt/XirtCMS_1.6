<?php

/**
 * Controller for XirtCMS Usergroup
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UsergroupController extends XController {

   /**
    * @var An alias for the Model for this Controller
    *
    * @access protected
    */
   protected $_usergroup = null;


   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;

      if (in_array($this->_action, array('show', 'edit', 'delete'))) {

         // Load existing data
         $this->_model->load(XTools::getParam('id', 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Usergroup not found", E_USER_NOTICE);
            exit;

         }

      }

      $this->_usergroup = $this->_model;

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
      global $xCom;

      $this->_usergroup->set('rank',     XTools::getParam('nx_rank', 0, _INT));
      $this->_usergroup->set('name',     XTools::getParam('nx_name'));
      $this->_usergroup->set('language', XTools::getParam('nx_language'));

      $list = new UsergroupsModel();
      $list->load();

      // Validation: already exists (rank)
      if ($list->getItemByAttribute('rank', $this->_usergroup->rank)) {
         die($xCom->xLang->messages['rankExists']);
      }

      $this->_usergroup->add();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {

      $this->_usergroup->set('name', XTools::getParam('x_name'));
      $this->_usergroup->save();

   }


   /**
    * Deletes the data in the Model
    *
    * @access protected
    */
   protected function delete() {
      global $xCom;

      $this->_usergroup->delete();
      $list = new UsergroupsModel();

      if ($list->load($this->_usergroup->rank) && !$list->count()) {
         die($xCom->xLang->messages['rankRemoved']);
      }

   }

}
?>