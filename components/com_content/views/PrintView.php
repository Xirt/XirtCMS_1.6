<?php

/**
 * View for the print version of the model
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class PrintView extends XComponentView {


   /**
    * @var The defaul template file to load
    * @access protected
    */
   protected $_file = 'version-print.tpl';


   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {
      global $xConf;

      $xConf->hideTemplate();
      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign('item', $this->_model);

   }

}
?>