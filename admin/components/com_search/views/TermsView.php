<?php

/**
 * View for XirtCMS Search Terms
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TermsView extends XJSONView {

   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = $this->_model->_list;
      parent::_init();

   }

}
?>