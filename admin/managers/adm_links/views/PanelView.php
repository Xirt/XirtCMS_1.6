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

      XPage::addStylesheet('managers/adm_links/templates/css/main.css');
      XPage::addScript('managers/adm_links/templates/js/manager.js');
      XPage::addScript('managers/adm_links/templates/js/viewer.js');

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

   }

}
?>