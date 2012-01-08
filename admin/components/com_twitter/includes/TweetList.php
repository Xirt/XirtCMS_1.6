<?php

/**
 * List containing instances of XItem (Twitter tweets)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class TweetList extends XContentList {

   /**
    * @var String Table with item information
    */
   var $table = '#__twitter';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'created';


   /**
    * @var Array The list of columns used for every item
    */
   var $columns = array('author', 'content', 'created', 'status');

}
?>