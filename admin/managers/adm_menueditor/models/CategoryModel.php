<?php

/**
 * Model for a XirtCMS content category
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class CategoryModel {

   /**
    * @var The base URL to a single content item (front-end)
    */
   const URI_CONTENT = "index.php?content=com_content&amp;id=%d";


   /**
    * @var The list with content items for this category
    */
   protected $_list = array();


   /**
    * Creates a new category with the given information
    *
    * @param $id The id of the category
    * @param $name The name of the category
    */
   function __construct($id, $name) {

      $this->name = $name;
      $this->id = $id;

   }


   /**
    * Adds a content item to the category
    *
    * @param $content The content item to add
    */
   public function add($content) {

      $link = sprintf(self::URI_CONTENT, $content->xid);
      $this->_list[$link] = $content->title;

   }


   /**
    * Returns the list of ontent items for this category
    *
    * @return Array The list of content items
    */
   public function toArray() {
      return $this->_list;
   }

}
?>