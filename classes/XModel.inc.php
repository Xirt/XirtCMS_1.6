<?php

/**
 * Default Model for XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XModel {

   /**
    * Method to load data
    */
   public function load() {
   }


   /**
    * Sets an attribute for this instance
    *
    * @param $attrib The attribute to set
    * @param $value The value for the given variable
    * @param $unset Used to unset variables (optional, default: false)
    */
   public function set($attrib, $value, $unset = false) {

      $this->$attrib = $value;

      if (isset($unset) && $unset === true) {
         unset($this->$attrib);
      }

   }


   /**
    * Returns an attribute for this instance
    *
    * @param $attrib The attribute to return
    * @return mixed The requested attribute or null on failure
    */
   public function get($attrib) {
      return isset($this->$attrib) ? $this->$attrib : null;
   }

}
?>