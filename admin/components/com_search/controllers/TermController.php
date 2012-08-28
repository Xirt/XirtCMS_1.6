<?php

/**
 * Controller for XirtCMS Search Terms
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TermController extends XController {

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

            trigger_error("[Controller] Search Term not found", E_USER_NOTICE);
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

      $this->_model->set('impressions', XTools::getParam('nx_impressions', 0, _INT));
      $this->_model->set('term',        XTools::getParam('nx_term'));
      $this->_model->set('uri',         XTools::getParam('nx_uri'));
      $this->_model->set('language',    XTools::getParam('nx_language'));
      $this->_model->add();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {

      $this->_model->set('impressions', XTools::getParam('x_impressions', 0, _INT));
      $this->_model->set('term',        XTools::getParam('x_term'));
      $this->_model->set('uri',         XTools::getParam('x_uri'));
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