<?php

/**
 * Controller for a Log Entry
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LogEntryController extends XController {


   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;
      $this->_model->load(XTools::getParam('id', 0, _INT));

   }


   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {
   }


   /**
    * Removes the model
    *
    * @access protected
    */
   protected function delete() {
      $this->_model->delete();
   }

}
?>