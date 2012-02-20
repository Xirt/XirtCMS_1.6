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
    * Creates a new translation of a menu node
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

      // Database query
      $query = 'SELECT * FROM #__menunodes WHERE id = :id';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      if ($dbRow = $stmt->fetchObject()) {

         foreach ($dbRow as $attrib => $value) {
            $this->$attrib = $value;
         }

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

      // Database query (manual query, as XNode has additional variables)
      $query = 'UPDATE #__menunodes           '.
               'SET name       = :name,       '.
               '    mobile     = :mobile,     '.
               '    link_type  = :link_type,  '.
               '    image      = :image,      '.
               '    css_name   = :css_name,   '.
               '    link       = :link,       '.
               '    home       = :home,       '.
               '    sitemap    = :sitemap,    '.
               '    ordering   = :ordering,   '.
               '    published  = :published,  '.
               '    access_min = :access_min, '.
               '    access_max = :access_max  '.
               'WHERE id = :id                ';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':access_min', $this->access_min, PDO::PARAM_INT);
      $stmt->bindParam(':access_max', $this->access_max, PDO::PARAM_INT);
      $stmt->bindParam(':published', $this->published, PDO::PARAM_INT);
      $stmt->bindParam(':link_type', $this->link_type, PDO::PARAM_INT);
      $stmt->bindParam(':css_name', $this->css_name, PDO::PARAM_STR);
      $stmt->bindParam(':ordering', $this->ordering, PDO::PARAM_INT);
      $stmt->bindParam(':sitemap', $this->sitemap, PDO::PARAM_INT);
      $stmt->bindParam(':mobile', $this->mobile, PDO::PARAM_INT);
      $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
      $stmt->bindParam(':home', $this->home, PDO::PARAM_INT);
      $stmt->bindParam(':link', $this->link, PDO::PARAM_STR);
      $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
      $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
      $stmt->execute();

   }


   /**
    * Removes item from the database
    */
   public function remove() {
      global $xDb;

      // Database query
      $query = 'DELETE FROM #__menunodes WHERE id = :id';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
      $stmt->execute();

   }

}
?>