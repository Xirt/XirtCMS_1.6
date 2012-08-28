<?php

/**
 * Models for XirtCMS Components
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ComponentsModel extends XContentList {

   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__components';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'name';


   /**
    * @var Array The list of columns used for every item
    */
   protected $_columns = array('id', 'name');


   /**
    * Initializes Model with requested values
    */
   function __construct() {

      $this->setStart(XTools::getParam('start', 0, _INT));
      $this->setLimit(XTools::getParam('limit', 999, _INT));
      $this->setOrder(XTools::getParam('order', 'DESC', _STRING));
      $this->setColumn(XTools::getParam('column', 'id', _STRING));

   }

}
?>