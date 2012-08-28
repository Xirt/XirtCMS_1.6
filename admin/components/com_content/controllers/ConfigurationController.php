<?php

/**
 * Controller for XirtCMS Content Viewer Configuration
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ConfigurationController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;
      $this->_model->load();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {

      $this->_model->set('css_name',      XTools::getParam('item_css_name'));
      $this->_model->set('show_title',    XTools::getParam('item_show_title',    0, _INT));
      $this->_model->set('show_author',   XTools::getParam('item_show_author',   0, _INT));
      $this->_model->set('show_created',  XTools::getParam('item_show_created',  0, _INT));
      $this->_model->set('show_modified', XTools::getParam('item_show_modified', 0, _INT));
      $this->_model->set('download_icon', XTools::getParam('item_download_icon', 0, _INT));
      $this->_model->set('print_icon',    XTools::getParam('item_print_icon',    0, _INT));
      $this->_model->set('mail_icon',     XTools::getParam('item_mail_icon',     0, _INT));
      $this->_model->set('back_icon',     XTools::getParam('item_back_icon',     0, _INT));
      $this->_model->save();

   }

}
?>