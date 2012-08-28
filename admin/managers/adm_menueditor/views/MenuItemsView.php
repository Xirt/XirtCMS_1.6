<?php

/**
 * View for XirtCMS Menu Items
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MenuItemsView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->toArray();
   }

}
?>