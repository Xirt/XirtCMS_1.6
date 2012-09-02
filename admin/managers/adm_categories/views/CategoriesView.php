<?php

/**
 * View for XirtCMS Categories
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class CategoriesView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->toArray();
   }

}
?>