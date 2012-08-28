<?php

/**
 * View for XirtCMS Usergroups
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UsergroupsView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>