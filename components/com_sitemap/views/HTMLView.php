<?php

/**
 * View for the component in HTML
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class HTMLView extends XComponentView {


   /**
    * @var The defaul template file to load
    * @access protected
    */
   protected $_file = 'html.tpl';


   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign('menus', $this->_model->list);

   }

}
?>