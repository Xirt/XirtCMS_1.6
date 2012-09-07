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

      XPage::addStylesheet('managers/adm_files/templates/css/main.css?');
      XPage::addScript('managers/adm_files/templates/js/fileviewer.js?');
      XPage::addScript('managers/adm_files/templates/js/filetree.js?');
      XPage::addScript('managers/adm_files/templates/js/manager.js?');
      XPage::addScript('../js/src/xupload.js?');
      XInclude::plugin('slimbox');

      parent::__construct($model);

   }

}
?>