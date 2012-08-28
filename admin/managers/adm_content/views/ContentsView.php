<?php

/**
 * View for XirtCMS Content
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentsView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>