<?php

/**
 * Object containing details about a Static Content item (translation)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Translation extends XItem {

   /**
    * CONSTRUCTOR
    *
    * @param $attribs Array with property/value combinations for initialization
    */
   function __construct($attribs = array()) {

      if (count($attribs)) {

         foreach ($attribs as $attrib => $value) {
            $this->$attrib = $value;
         }

         return $this->set('config', json_decode($this->config));
      }

      $this->_resetConfiguration();
   }


   /**
    * Loads item information from the database
    *
    * @param $id The ID of the item in the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__content', $id);
      $this->set('config', json_decode($this->config));

   }


   /**
    * Resets the configuration for the current item to the default settings
    *
    * @private
    */
   private function _resetConfiguration() {

      $config = (Object)array();

      $config->css_name      = '';
      $config->show_title    = -1;
      $config->show_author   = -1;
      $config->show_created  = -1;
      $config->show_modified = -1;
      $config->back_icon     = -1;
      $config->download_icon = -1;
      $config->print_icon    = -1;
      $config->mail_icon     = -1;

      $this->config = $config;
   }



   /***************/
   /* MODIFY (DB) */
   /***************/

   /**
    * Toggles publication status
    */
   public function toggleStatus() {

      $this->set('published', intval(!$this->published));
      $this->save();

   }


   /**
    * Toggles mobile status
    */
   public function toggleMobile() {

      $this->set('mobile', intval(!$this->mobile));
      $this->save();

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      $this->set('config', json_encode($this->config));
      parent::saveToDatabase('#__content');

   }


   /**
    * Removes item from the database
    */
   public function remove() {
      parent::removeFromDatabase('#__content');
   }

}
?>