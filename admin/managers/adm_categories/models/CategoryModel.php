<?php

/**
 * Model for a XirtCMS Category
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class CategoryModel extends XItemModel {

   /**
    * Creates a new XItemModel with given attributes
    *
    * @param $attribs Property/value combinations for initialization (optional)
    */
   function __construct($attribs = array()) {

      parent::__construct($attribs);
      $this->_resetConfiguration();

   }


   /**
    * Resets the configuration for the current item to the default settings
    *
    * @private
    */
   private function _resetConfiguration() {

      $this->config = (Object)array();
      $this->config->css_name      = '';
      $this->config->amount_full   = 1;
      $this->config->amount_title  = 15;
      $this->config->show_archive  = 0;
      $this->config->order_col     = null;
      $this->config->order         = null;
      $this->config->show_title    = -1;
      $this->config->show_author   = -1;
      $this->config->show_created  = -1;
      $this->config->show_modified = -1;
      $this->config->back_icon     = -1;
      $this->config->download_icon = -1;
      $this->config->print_icon    = -1;
      $this->config->mail_icon     = -1;


   }

   /**
    * Loads item information from the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__content_categories', $id);
      $this->set('config', json_decode($this->config));

   }


   /**
    * Saves changes to the item to the database
    */
   public function add() {

      $this->set('config', json_encode($this->config));
      parent::addToDatabase('#__content_categories');

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      $this->set('config', json_encode($this->config));
      parent::saveToDatabase('#__content_categories');

   }


   /**
    * Removes item from the database
    */
   public function delete() {
      parent::deleteFromDatabase('#__content_categories');
   }

}
?>