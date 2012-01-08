<?php

/**
 * List containing instances of XItem (XirtCMS templates)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 -2012
 * @package    XirtCMS
 */
class TemplateList extends XContentList {

   /**
    * @var String Table with item information
    */
   var $table = '#__templates';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'active';

}
?>