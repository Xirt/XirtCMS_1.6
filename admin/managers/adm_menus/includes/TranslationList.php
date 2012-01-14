<?php

/**
 * List containing simple instances of Translation (XirtCMS menus)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TranslationList extends XTranslationList {

   /**
    * @var String with the name of the table containing the information
    */
   var $table = "#__menus";


   /**
    * Changes the position of the item in the list
    *
    * @param $position Integer with new position (ordering)
    */
   public function moveTo($position) {

      $this->set('ordering', $position);

   }

}
?>