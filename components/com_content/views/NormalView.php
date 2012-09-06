<?php

/**
 * View for the normal version of the model
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class NormalView extends XComponentView {


   /**
    * @var The defaul template file to load
    * @access protected
    */
   protected $_file = 'version-normal.tpl';


   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {
      global $xConf;

      // Modify page properties
      XPage::addScript('components/com_content/js/main.js');
      XPage::addInformation("keywords", $this->_model->meta_keywords);
      XPage::addInformation("description", $this->_model->meta_description);

      // Modify page title
      XPage::extendTitle($this->_model->title);
      if (trim($this->_model->meta_title)) {
         XPage::setTitle($this->_model->meta_title);
      }

      // Template
      parent::_init();
      $this->_template->assign('xConf', $xConf);
      $this->_template->assign('item', $this->_model);

   }

}
?>