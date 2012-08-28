<?php

/**
 * View for the panel
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

      XPage::addScript('components/com_search/templates/js/viewer.js');
      XPage::addScript('components/com_search/templates/js/manager.js');
      XPage::addStylesheet('components/com_search/templates/css/main.css');

      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign('languages', $this->_model->languages);
      $this->_template->assign('configuration', $this->_model->configuration);

   }

}
?>