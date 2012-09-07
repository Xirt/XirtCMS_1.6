<?php

/**
 * View for list of items (folders or files)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ListView extends XJSONView {

   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = $this->_model->toArray();
      parent::_init();

   }

}
?>