<?php

/**
 * View for Users
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UsersView extends XJSONView {

   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = $this->_model->_list;

      // Remove sensitive information
      foreach ($this->_model as $data) {

         $data->set('password', null, true);
         $data->set('salt', null, true);

      }

   }

}
?>