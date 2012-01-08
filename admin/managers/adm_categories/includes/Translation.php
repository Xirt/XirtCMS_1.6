<?php

/**
 * Object containing details about a menu node
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Translation extends XNode {

   /**
    * @var The ID of the item
    */
   var $id = 0;


   /**
    * CONSTRUCTOR
    *
    * @param $attribs Array with property/value combinations for initialization
    */
   function __construct($attribs = array()) {

      foreach ($attribs as $attrib => $value) {
         $this->$attrib = $value;
      }

   }


   /**
    * Loads item information from the database
    *
    * @param $id The ID of the item in the database
    */
   public function load($id) {
      global $xDb;

      $query = "SELECT *
                FROM #__content_categories
                WHERE id = '{$id}'";
      $xDb->setQuery($query);
      $dbRow = $xDb->loadRow();

      foreach ($dbRow ? $dbRow : array() as $attrib => $value) {

         if ($attrib == 'config') {
            $value = json_decode($value);
         }

         $this->$attrib = $value;
      }

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
    * Resets the configuration for the current item to the default settings
    *
    * @private
    */
   private function _resetConfiguration() {

      $config = (Object)array();

      $config->css_name      = '';
      $config->amount_full   = 1;
      $config->amount_title  = 15;
      $config->show_archive  = false;
      $config->order_col     = 'created';
      $config->order         = 'DESC';
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

      $this->published = intval(!$this->published);
      $this->save();

   }


   /**
    * Toggles sitemap status
    */
   public function toggleSitemap() {

      $this->sitemap = intval(!$this->sitemap);
      $this->save();

   }


   /**
    * Toggles mobile status
    */
   public function toggleMobile() {

      $this->mobile = intval(!$this->mobile);
      $this->save();

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      global $xDb;

      foreach ($this as $attrib => $value) {

         if ($attrib == 'config') {
            $value = json_encode($value);
         }

         $this->$attrib = XTools::addslashes($value);

      }

      $query = "UPDATE #__content_categories
                SET name       = '{$this->name}',
                    mobile     = '{$this->mobile}',
                    sitemap    = '{$this->sitemap}',
                    config     = '{$this->config}',
                    ordering   = '{$this->ordering}',
                    published  = '{$this->published}',
                    access_min = '{$this->access_min}',
                    access_max = '{$this->access_max}'
                WHERE id = {$this->id}";
      $xDb->setQuery($query);
      $xDb->query();

   }


   /**
    * Removes item from the database
    */
   public function remove() {
      global $xDb;

      $query = "DELETE FROM #__content_categories
                WHERE id = {$this->id}";
      $xDb->setQuery($query);
      $xDb->query();

   }

}
?>