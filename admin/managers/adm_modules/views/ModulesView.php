<?php

/**
 * View for XirtCMS Modules
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ModulesView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>