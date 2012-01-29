<?php

/**
 * Object containing details about a Module instance (translation)
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
    * @param $attribs Property/value combinations for initialization (optional)
    */
   function __construct($attribs = array()) {

      if (count($attribs) && array_key_exists('config', $attribs)) {

         parent::__construct($attribs);
         $this->set('config', json_decode($this->config));

      }

   }


   /**
    * Loads item information from the database
    *
    * @param $id The ID of the item in the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__modules', $id);

      $configuration = json_decode($this->config);
      $this->resetConfiguration();

      foreach ($configuration as $setting => $value) {
         $this->config->$setting = $value;
      }

   }


   /**
    * Resets the configuration to hold all details
    *
    * @param $type The module type of this translation
    */
   public function setConfiguration($type = null) {

      $type = $type ? $type : $this->type;

      foreach(XModule::getConfiguration($type) as $setting => $details) {

         $details->value = $details->default;

         if (isset($this->config->$setting)) {
            $details->value = $this->config->$setting;
         }

         if ($details->type == 'menu') {

            $details->type = 'select';
            $details->options = array();

            foreach (Xirt::getMenus() as $menu) {
               $details->options[$menu->title] = $menu->xid;
            }

         }

         unset($details->default);
         $this->config->$setting = $details;
      }

   }


   /**
    * Resets the configuration for the item
    */
   public function resetConfiguration() {

      $configuration = (Object)array();
      foreach(XModule::getConfiguration($this->type) as $setting => $details) {
         $configuration->$setting = $details->default;
      }

      $this->set('config' , $configuration);

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

      $this->config = json_encode($this->config);
      parent::saveToDatabase('#__modules');

   }


   /**
    * Removes item from the database
    */
   public function remove() {

      parent::removeFromDatabase('#__modules');

   }

}
?>