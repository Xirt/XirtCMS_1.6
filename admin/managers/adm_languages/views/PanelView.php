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

      XPage::addScript('managers/adm_languages/templates/js/viewer.js');
      XPage::addScript('managers/adm_languages/templates/js/manager.js');
      XPage::addStylesheet('managers/adm_languages/templates/css/main.css');

      parent::__construct($model);

   }
}
?>