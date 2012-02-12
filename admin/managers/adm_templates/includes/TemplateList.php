<?php

/**
 * List containing instances of XItem (XirtCMS templates)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TemplateList extends XContentList {

   /**
    * @var String Table with item information
    */
   protected $_table = '#__templates';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'active';

}
?>