<?php

/**
 * List containing instances of XItem (XirtCMS menus)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class ContentList extends XContentList {

   /**
    * @var String with the name of the table containing the information
    */
   var $table = "#__menus";


   /**
    * Loads list information from the database
    *
    * @param $iso The language to load (e.g. 'en-GB')
    * @return boolean True on succes, false on failure
    */
   public function load($iso = null) {

      return ($this->table ? !$this->_load($iso) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @access private
    * @param $iso The language to load (e.g. 'en-GB')
    */
   private function _load($iso = null) {
      global $xConf, $xDb;

      $languageList = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languageList) ? $iso : $xConf->language;
      $iso = intval($languageList[$iso]->preference);

      $query = "SELECT *
                FROM (
                   SELECT t1.*, t2.preference
                   FROM {$this->table} AS t1
                   INNER JOIN #__languages AS t2 ON t1.language = t2.iso
                   ORDER BY replace(t2.preference, {$iso}, 0)
                ) AS t3
                GROUP BY xid
                ORDER BY ordering";
      $xDb->setQuery($query);

      foreach ($xDb->loadObjectList() as $dbRow) {
         $this->_add(new Translation($dbRow), false);
      }

   }


   /**
    * Adds a new item to the list
    *
    * @param $item The item to add
    * @return boolean True
    */
   public function add($item) {

      $item->set('xid', $this->getMaximum('xid') + 1);
      $item->set('ordering', $this->getMaximum('ordering') + 1);

      return parent::_add($item);
   }


   /**
    * Moves an item up
    *
    * @param xId Integer with the xID of the item to move
    */
   public function moveUp($xId) {

      if (!$item = $this->getItemByAttribute('xid', $xId)) {
         return false;
      }

      // Search previous item
      foreach (array_reverse($this->cList) as $previous) {

         if ($previous->ordering < $item->ordering) {
            break;
         }

      }

      $list = new TranslationList();
      $list->load($item->xid);
      $list->moveTo($previous->ordering);

      $list = new TranslationList();
      $list->load($previous->xid);
      $list->moveTo($item->ordering);

   }


   /**
    * Moves an item down
    *
    * @param $xId Integer with the xID of the item to move
    */
   public function moveDown($xId) {

      if (!$item = $this->getItemByAttribute('xid', $xId)) {
         return false;
      }

      // Search next item
      foreach ($this->cList as $next) {

         if ($next->ordering > $item->ordering) {
            break;
         }

      }

      $list = new TranslationList();
      $list->load($next->xid);
      $list->moveTo($item->ordering);

      $list = new TranslationList($item->xid);
      $list->load($item->xid);
      $list->moveTo($next->ordering);

   }

}
?>