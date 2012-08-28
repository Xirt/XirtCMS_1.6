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

      XPage::addScript('components/com_twitter/templates/js/viewer.js');
      XPage::addScript('components/com_twitter/templates/js/manager.js');
      XPage::addStylesheet('components/com_twitter/templates/css/main.css');

      parent::__construct($model);

   }

}
?>