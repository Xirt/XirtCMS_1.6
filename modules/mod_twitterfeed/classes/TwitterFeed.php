<?php

/**
 * Class to load / save a Twitter feed from the web
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class TwitterFeed {

   /**
    * @var String with base location of the feed
    */
   const FEED = "http://search.twitter.com/search.rss?q=";


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
    * @param $query The search query for the twitter feed
    */
   function __construct($query) {
      $this->_init($query);
   }


   /**
    * Initializes the feed by loading it in a DOMDocument object
    *
    * @param $query The search query for the Twitter feed
    */
   private function _init($query) {

      $this->_feed = new DOMDocument();
      $this->_feed->load(self::FEED . $query);

   }


   /**
    * Parses the current feed
    *
    * @return int The amount of parsed items
    */
   public function parse() {

      foreach ($this->_getItems() as $item) {

         $this->_list[] = new Tweet(
            $this->_parseGUID($this->_getValue($item, 'guid')),
            $this->_parseAccount($this->_getValue($item, 'author')),
            $this->_parseAuthor($this->_getValue($item, 'author')),
            $this->_getValue($item, 'image_link'),
            $this->_getValue($item, 'description'),
            $this->_getValue($item, 'pubDate')
         );

      }

      return count($this->_list);
   }


   /**
    * Saves the parsed items to the database
    */
   public function save() {

      foreach ($this->_list as $tweet) {
         $tweet->save();
      }

   }


   /**
    * Returns the current feed as an Array
    *
    * @return Array The current feed
    */
   public function toList() {
      return $this->_list;
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
    * Parses the GUID to a readable format (to String because of large numbers)
    *
    * @access private
    * @param $guid The GUID as given by the feed
    * @return String The GUID as an integer value
    */
   private function _parseGUID($guid) {

      // Save to array for E_STRICT
      $array = explode('/', $guid);

      return array_pop($array);
   }


   /**
    * Parses the account to a readable format
	 *
	 * @access private
    * @param $author The account as given by the feed
    * @return String The account as a String value
    */
   private function _parseAccount($author) {

      return substr($author, 0, strpos($author, '@'));
   }


   /**
    * Parses the author to a readable format
	 *
	 * @access private
    * @param $author The author as given by the feed
    * @return String The author as a String value
    */
   private function _parseAuthor($author) {

      return substr($author, strpos($author, '(') + 1, -1);
   }

}
?>