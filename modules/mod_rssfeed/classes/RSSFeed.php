<?php

/**
 * Class to load RSS feed from the web
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2012
 * @package    XirtCMS
 */
class RSSFeed {


   /**
    * @var The loaded feed (DOMDocument)
    */
   var $_feed = null;


   /**
    * @var Array with the parsed entries of the feed
    */
   var $_list = array();


   /**
    * Constructor
    *
    * @param $feed The location of the RSS-feed
    * @param $useCache Toggles caching of the feed
    */
   function __construct($feed, $useCache = true) {
      $this->_init($feed, $useCache);
   }


   /**
    * Initializes the feed by loading it in a DOMDocument object
    *
    * @param $feed The location of the RSS-feed
    */
   private function _init($feed, $useCache) {
      global $xCache;

      if ($useCache) {

         $this->_feed = new DOMDocument();
         $this->_feed->loadXML($xCache->loadFile($feed));

      } else {

         $this->_feed = new DOMDocument();
         $this->_feed->load($feed);

      }

   }


   /**
    * Parses the current feed
    *
    * @return int The amount of parsed items
    */
   public function parse() {

      foreach ($this->_getItems() as $item) {

         $this->_list[] = new RSSItem(
            $this->_getValue($item, 'title'),
            $this->_getValue($item, 'description'),
            $this->_getValue($item, 'link'),
            $this->_getValue($item, 'pubDate')
         );

      }

      return count($this->_list);
   }


   /**
    * Returns the current feed as an Array
    *
    * @param $limit Integer to limit the amount of items returned (optional)
    * @return Array The current feed
    */
   public function toArray($limit = null) {

      if (!is_null($limit) && count($this->_list)) {
         return array_slice($this->_list, 0, abs($limit));
      }

      return $this->_list;
   }


   /**
    * Adds the given feed to this feed
    *
    * @param $feed The feed to add
    * @return int The amount of items in the list
    */
   public function merge($feed) {

      // Add all items
      foreach ($feed->toArray() as $item) {
         $this->_list[] = $item;
      }

      // Sort by date
      usort($this->_list, array('RSSFeed', '_sort'));

      return count($this->_list);
   }


   /**
    * Returns all items from the current feed
    *
    * @access private
    * @return Array The items in the feed
    */
   private function _getItems() {

      if ($items = $this->_feed->getElementsByTagName('item')) {
         return $items;
      }

      return array();
   }


   /**
    * Returns the requested attribute from the given item
    *
    * @access private
    * @param $item The item containing the requested attribute
    * @param $attrib The requested attribute
    * @return mixed Null on failure, the value on success
    */
   private function _getValue($item, $attrib) {

      if ($item = $item->getElementsByTagName($attrib)) {
         return $item->item(0)->nodeValue;
      }

      return null;
   }


   /**
    * Internal sorting method for feed items
    *
    * @access private
    * @param $a The first item to compare
    * @param $b The second item to compare
    * @return int -1, 0 or 1 for $a being newer, the same or older than $b
    */
   private static function _sort($a, $b) {

      if ($a->created > $b->created) {
         return -1;
      }

      return intval($a->created < $b->created);
   }

}
?>