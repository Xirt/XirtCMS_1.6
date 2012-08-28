<?php

/**
 * Controller for SEF Links
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LinkController extends XController {

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

            trigger_error("[Controller] SEF Link not found", E_USER_NOTICE);
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
   }


   /**
    * Adds the data in the Model
    *
    * @access protected
    */
   protected function add() {
      global $xCom;

      $this->_model->set('cid',         XTools::getParam('nx_cid', 0, _INT));
      $this->_model->set('alternative', XTools::getParam('nx_alternative'));
      $this->_model->set('query',       XTools::getParam('nx_query'));
      $this->_model->set('iso',         XTools::getParam('nx_language'));
      $this->_model->set('custom',      1);

      $list = new LinksModel();
      $list->load();

      // Validation: already exists (SEF link)
      $alternative = $this->_model->alternative;
      if ($list->getItemByAttribute('alternative', $alternative)) {
         die($xCom->xLang->messages['linkUsed']);
      }

      $this->_model->add();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {
      global $xCom;

      $this->_model->set('cid',         XTools::getParam('x_cid', 0, _INT));
      $this->_model->set('alternative', XTools::getParam('x_alternative'));
      $this->_model->set('query',       XTools::getParam('x_query'));

      $list = new LinksModel();
      $list->load();

      $alternative = $this->_model->alternative;
      if ($item = $list->getItemByAttribute('alternative', $alternative)) {

         if ($item->id != $this->_model->id) {
            die($xCom->xLang->messages['linkUsed']);
         }

      }

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