<?php

/**
 * List containing simple instances of Translation
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentList extends XContentList {

   /**
    * @var String with the name of the table containing the information
    */
   var $table = "#__modules";


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'position';


   /**
    * @var Array The list of columns used for every item
    */
   var $columns = array(
       'xid', 'name', 'type', 'position', 'published', 'mobile'
   );


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
      global $xDb;

      $languageList = Xirt::getLanguages(true);
      $iso = array_key_exists($iso, $languageList) ? $iso : $xConf->language;
      $iso = intval($languageList[$iso]->preference);

      $query = "SELECT
                  id, xid, name, position, type, published, mobile, language
                FROM (
                   SELECT t1.*, t2.preference
                   FROM %s AS t1
                   INNER JOIN #__languages AS t2 ON t1.language = t2.iso
                   ORDER BY replace(t2.preference, %s, 0)
                ) AS t3
                GROUP BY xid
                ORDER BY {$this->column} {$this->order}";
      $xDb->setQuery(sprintf($query, $this->table, $iso));

      foreach ($xDb->loadObjectList() as $dbRow) {
         $this->_add(new XItem($dbRow), false);
      }

   }


   /**
    * Adds a new item
    *
    * @param $item The item to add
    * @return boolean True
    */
   public function add($item) {

      $item->set('config', json_encode($item->config));

      return $this->_add($item);
   }

}
?>