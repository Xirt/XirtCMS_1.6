<?php

/**
 * Controller for the (default) XirtCMS Search Component
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ComponentController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {
      global $xCom;

      $this->_model = new $this->_model;

      if (in_array($this->_action, array('edit'))) {

         // Load existing data
         $this->_model->load($xCom->name);
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Component not found", E_USER_NOTICE);
            exit;

         }

      }

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {

      $config = (object) array();
      $config->search_type    = XTools::getParam('x_search_type',    0,   _INT);
      $config->recording      = XTools::getParam('x_recording',      0,   _INT);
      $config->default_value  = XTools::getParam('x_default_value',  '',  _STRING);
      $config->default_limit  = XTools::getParam('x_default_limit',  10,  _INT);
      $config->default_method = XTools::getParam('x_default_method', 0,   _INT);
      $config->titlelength    = XTools::getParam('x_titlelength',    250, _INT);
      $config->textlength     = XTools::getParam('x_textlength',     100, _INT);
      $config->node_id        = XTools::getParam('x_node_id',        0,   _INT);

      // Save the right default method
		$method = 'x_default_method_' . $config->search_type;
      $config->default_method = XTools::getParam($method, 0, _INT);

      $this->_model->set('config', $config);
      $this->_model->save();

   }

}
?>