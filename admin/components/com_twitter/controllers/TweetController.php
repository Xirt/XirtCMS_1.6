<?php

/**
 * Controller for single Tweets
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TweetController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;

      if (in_array($this->_action, array('show', 'toggleStatus', 'delete'))) {

         // Load existing data
         // TODO: Check what happens with large ID's, Model converts to _INT
         // for security purposes
         $this->_model->load(XTools::getParam('id', 0));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Tweet not found", E_USER_NOTICE);
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