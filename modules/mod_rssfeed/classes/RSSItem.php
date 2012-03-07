<?php

/**
 * Class used for creation of items of RSS feeds
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2012
 * @package    XirtCMS
 */
class RSSItem {

   /**
    * @var The title of the item
    */
   var $title = null;


   /**
    * @var The description of the item
    */
   var $description = null;


   /**
    * @var The link to the item
    */
   var $location = null;


   /**
    * @var The creation date of the item
    */
   var $created = null;


   /**
    * Constructor
    *
    * @param $title The title of the item
    * @param $content The description of the item
    * @param $location The link to the item
    * @param $created The creation date of the item
    */
   function __construct($title, $description, $location, $created) {

      $this->title       = $title;
      $this->description = $description;
      $this->location    = $location;
      $this->created     = new DateTime($created);

   }

}
?>