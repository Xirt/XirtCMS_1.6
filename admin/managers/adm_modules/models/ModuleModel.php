<?php

/**
 * Model for a XirtCMS Modules
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ModuleModel extends XItemModel {


   /**
    * Loads item information from the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__modules', $id);

      // Reset configuration
      $configuration = json_decode($this->config);
      $this->resetConfiguration();

      // Configure configuration for instance
      foreach ($configuration as $setting => $value) {
         $this->config->$setting = $value;
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
    * Saves changes to the item to the database
    */
   public function add() {

      $this->set('config', json_encode($this->config));
      parent::addToDatabase('#__modules');

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      $this->set('config', json_encode($this->config));
      parent::saveToDatabase('#__modules');

   }


   /**
    * Removes item from the database
    */
   public function delete() {
      parent::deleteFromDatabase('#__modules');
   }

}
?>