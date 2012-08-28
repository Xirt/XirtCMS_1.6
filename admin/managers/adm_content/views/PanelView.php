<?php

/**
 * View for the management panel
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class PanelView extends XComponentView {

   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {

      XPage::addScript('managers/adm_content/templates/js/viewer.js');
      XPage::addScript('managers/adm_content/templates/js/manager.js');
      XPage::addStylesheet('managers/adm_content/templates/css/main.css');

      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign('ranks', $this->_model->ranks);
      $this->_template->assign('options', $this->_model->options);
      $this->_template->assign('languages', $this->_model->languages);

   }

}
?>