<?php

/**
 * Controller for XirtCMS Language
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LanguageController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;

      if (in_array($this->_action, array('toggle'))) {

         // Load existing data
         $this->_model->load(XTools::getParam('id', 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Language not found", E_USER_NOTICE);
            exit;

         }

      }

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function toggle() {

      if (!($this->_model->preference === 1 && $this->_model->published)) {

         $current = $this->_model->get('published');

         $this->_model->set('published', intval(!$current));
         $this->_model->save();

      }

   }

}
?>