<?php

/**
 * View for User
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UserView extends XJSONView {

   protected function _init() {

      // Remove sensitive information
      $this->_model->set('password', null, true);
      $this->_model->set('salt', null, true);

   }

}
?>