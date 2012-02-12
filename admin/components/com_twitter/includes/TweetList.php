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
   protected $_table = '#__twitter';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'created';


   /**
    * @var Array The list of columns used for every item
    */
   protected $_columns = array('author', 'content', 'created', 'status');

}
?>