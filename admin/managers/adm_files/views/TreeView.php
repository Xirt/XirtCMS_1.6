<?php

/**
 * View for tree of folders
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TreeView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->toArray();
   }

}
?>