<?php

/**
 * View for XirtCMS Components
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ComponentsView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>