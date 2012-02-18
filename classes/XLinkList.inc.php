<?php

/**
 * Database Class for storing XLinks
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XLinkList {

   /**
    * @var The status of this list
    */
   private $_isLoaded = false;


   /**
    * @var Array containing all listed items
    */
   private $_list = array();


   /**
    * Creates a new XLinkList (filled if SEF URLs are enabled)
    */
   function __construct() {
      global $xConf;

      if ($xConf->alternativeLinks) {
         $this->load();
      }

   }


   /**
    * Fills the list with items from the database
    */
   public function load() {
      global $xDb;

      // Enable reload of list
      if ($this->_isLoaded) {
         $this->_list = array();
      }

      // Database query
      $query = 'SELECT cid, iso, query, alternative FROM #__links';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Populate instance
      while  ($dbRow = $stmt->fetchObject()) {

         $this->_list[] = new XLink(
         $dbRow->cid,
         $dbRow->iso,
         $dbRow->query,
         $dbRow->alternative
         );

      }

      return ($this->_isLoaded = true);
   }


   /**
    * Adds a link to the list (if not already existing)
    *
    * @param $cId Int with the cId of the page
    * @param $iso String with the language of the page
    * @param $original String with the original URL of the page
    * @param $name String with the search term for the URL
    */
   function add($item) {
      global $xConf, $xDb;

      // Item already exists
      if ($this->returnLinkByQuery($item->query, $item->iso)) {
         return false;
      }

      return ($this->_list[] = $item) && $item->save();
   }


   /**
    * Returns XLink by link (SEF)
    *
    * @param $link String holding the SEF variant of the link
    * @return mixed Returns the original XLink on success, null otherwhise
    */
   function returnLinkByAlternative($link) {

      foreach ($this->_list as $item) {

         if ($item->alternative == $link) {
            return $item;
         }

      }

      return null;
   }


   /**
    * Returns XLink by original query
    *
    * @param $query String holding the original query (order alphabetically)
    * @param $iso String holding the language of the link (optional)
    * @return mixed Returns the XLink on success, null otherwhise
    */
   function returnLinkByQuery($query, $iso = null) {
      global $xConf;

      $iso = $iso ? $iso : $xConf->language;

      foreach ($this->_list as $item) {

         if ($item->query == $query && $item->iso == $iso) {
            return $item;
         }

      }

      return null;
   }

}
?>