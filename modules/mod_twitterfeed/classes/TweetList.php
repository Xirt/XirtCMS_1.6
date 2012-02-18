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
   protected $_list = array();


   /**
    * @var Array The accounts represented in the list
    */
   protected $_accounts = array();


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

      // Database query
      $query  = 'SELECT *               '.
                'FROM #__twitter        '.
                'WHERE published != 0   '.
                '  AND (account=\'%s\') '.
                '  AND id > :id         '.
                'ORDER BY id DESC       '.
                'LIMIT 0, %s            ';
      $query = sprintf($query, $this->_getQuery(), $limit);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(':id', '10', PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {

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