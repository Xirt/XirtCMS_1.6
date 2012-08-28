<?php

/**
 * Model for a XirtCMS Content Configuration
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ConfigurationModel extends XModel {

   /**
    * Loads item information from the database
    */
   public function load() {
      global $xCom;

      foreach ($xCom->xConf as $attrib => $value) {
         $this->$attrib = $value;
      }

   }


   /**
    * Saves all changes to the item to the database
    */
   public function save() {
      global $xDb;

      $data = array('config' => json_encode(get_object_vars($this)));
      $xDb->update('#__components', $data, "type = 'com_content'");

   }

}
?>