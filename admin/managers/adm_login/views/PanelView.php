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
      global $xConf;

      $xConf->hideTemplate();
      XPage::addScript('managers/adm_login/templates/js/main.js');
      XPage::addStylesheet('managers/adm_login/templates/css/main.css', 1);
      XPage::addStylesheet('managers/adm_login/templates/css/msie.css', 1, true);

      parent::__construct($model);

   }

}
?>