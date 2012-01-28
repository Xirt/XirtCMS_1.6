<?php

/**
 * Class to load / save a tweets from / to the database
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class TweetList {

   /**
    * @var Array with the parsed entries of the feed
    */
   var $_list = array();


   /**
   * @var Array The accounts represented in the list
   */
   var $_accounts = array();


   /**
    * Constructor
    */
   function __construct($accounts) {
      $this->_accounts = $accounts;
   }


   /**
    * Initializes the list
    */
   private function _getQuery() {
      return implode("' OR account='", $this->_accounts);
   }


   /**
    * Saves the parsed items to the database
    *
    * @param $id The ID of the tweet to start at
    * @param $limit The number of tweets to load (maximum)
    */
   public function load($id = 0, $limit = 10) {
      global $xDb;

      $query  = "SELECT *
                 FROM #__twitter
                 WHERE published != 0
      				  AND (account='{$this->_getQuery()}')
                    AND id > {$id}
                 ORDER BY id DESC
                 LIMIT 0, {$limit}";
      $xDb->setQuery($query);

      foreach ($xDb->loadObjectList() as $dbRow) {

         $this->_list[] = new Tweet(
            $dbRow->id,
            $dbRow->account,
            $dbRow->author,
            $dbRow->avatar,
            $dbRow->content,
            $dbRow->created
         );

      }

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
    * Returns the current feed as an Array
    *
    * @return Array The current feed
    */
   public function toJSON() {
      global $xConf;

      foreach ($this->_list as $tweet) {
         $tweet->created = $tweet->created->format($xConf->timeFormat);
      }

      return json_encode($this->_list);
   }


   /**
    * Shows the current feed in JSON format
    */
   public function show() {

      header('Content-type: application/x-json');
      die($this->toJSON());

   }

}
?>