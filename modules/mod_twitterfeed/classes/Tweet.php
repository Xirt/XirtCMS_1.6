<?php

/**
 * Class used for creation of instances of Twitter Tweets
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class Tweet {

   /**
    * @var The GUID of the Tweet
    */
   var $id = 0;


   /**
    * @var The account of the author of the Tweet
    */
   var $account = null;


   /**
    * @var The author of the Tweet
    */
   var $author = null;


   /**
   * @var The avatar of the author of the Tweet
   */
   var $avatar = null;


   /**
    * @var The content / text of the Tweet
    */
   var $content = null;


   /**
    * @var The creation date of the Tweet
    */
   var $created = null;


   /**
    * Constructor
    *
    * @param $guid The GUID of the Tweet
    * @param $account The account of the author of the Tweet
    * @param $author The author of the Tweet
    * @param $avatar The avatar of the author of the Tweet
    * @param $content The content / text of the Tweet
    * @param $created The creation date of the Tweet
    */
   function __construct($guid, $account, $author, $avatar, $content, $created) {

      $this->id       = $guid;
      $this->account  = $account;
      $this->author   = $author;
      $this->avatar   = $avatar;
      $this->content  = $content;
      $this->created  = new DateTime($created);

   }


   /**
    * Saves the tweet to the database (if not saved yet)
    */
   public function save() {
      global $xDb;

      $created = $this->created->format('Y-m-d H:i:s');

      // Database query
      $query = "INSERT IGNORE INTO #__twitter
                SET id      = :id,
                    account = :account,
                    author  = :author,
                    avatar  = :avatar,
                    content = :content,
                    created = :created";

      // Save data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(':account', $this->account, PDO::PARAM_STR);
      $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
      $stmt->bindValue(':author', $this->author, PDO::PARAM_STR);
      $stmt->bindValue(':avatar', $this->avatar, PDO::PARAM_STR);
      $stmt->bindValue(':created', $created, PDO::PARAM_STR);
      $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
      $stmt->execute();

   }

}
?>