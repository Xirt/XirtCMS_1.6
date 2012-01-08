<?php

/**
 * List containing instances of XItem (XirtCMS components)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class ComponentList extends XContentList {

   /**
    * @var String with the name of the table containing the information
    */
   var $table = '#__components';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'name';


   /**
    * @var Array The list of columns used for every item
    */
   var $columns = array('id', 'name');

}
?>