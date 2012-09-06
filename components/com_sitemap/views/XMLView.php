<?php

/**
 * View for the component in XML
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XMLView extends XComponentView {


   /**
    * @var The defaul template file to load
    * @access protected
    */
   protected $_file = 'xml.tpl';


   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {
      global $xConf;

      $xConf->hideTemplate();
      header('Content-type: application/xml; charset="utf-8"');

      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {
      global $xConf;

      parent::_init();
      $this->_template->assign('xConf', $xConf);
      $this->_template->assign('nodes', $this->_model->toArray());

   }

}
?>