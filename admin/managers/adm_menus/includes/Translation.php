<?php

/**
 * Object containing details about a XirtCMS menu (translation)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Translation extends XItem {

   /**
    * Loads item information from the database
    *
    * @param $id The ID of the item in the database
    */
   public function load($id) {

      parent::loadFromDatabase("#__menus", $id);

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

      parent::saveToDatabase("#__menus");

   }


   /**
    * Removes item from the database
    */
   public function remove() {

      parent::removeFromDatabase("#__menus");

   }

}
?>