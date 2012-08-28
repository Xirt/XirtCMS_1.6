<?php

/**
 * Models for Logs
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LogModel extends XContentList {

   /**
    * @var String Table with item information
    */
   protected $_table = '#__log';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'id';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_limit = 25;


   /**
    * @var Array The list of columns used for every item
    */
   protected $_columns = array(
      'id', 'error_no', 'error_msg', 'time'
   );

}
?>