<?php

/**
 * Model for a list of XirtCMS Usergroup (translations)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UsergroupListModel extends XTranslationList {

   /**
    * @var Integer The shared indentifier of the items in the list
    */
   var $rank = 0;


   /**
    * @var String with the name of the column acting as identifier (xId)
    */
   protected $_identifier = 'rank';


   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__usergroups';

}
?>