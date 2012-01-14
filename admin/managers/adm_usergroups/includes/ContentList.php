<?php

/**
 * List containing instances of XItem (XirtCMS usergroups)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentList extends XContentList {

   /**
    * @var String Table with item information
    */
   var $table = "#__usergroups";


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'rank';


   /**
    * @var Array The list of columns used for every item
    */
   var $columns = array('rank', 'name');


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
                GROUP BY rank
                ORDER BY {$this->column} {$this->order}";
      $xDb->setQuery($query);

      foreach ($xDb->loadObjectList() as $dbRow) {
         $this->_add(new Translation($dbRow), false);
      }

   }

}
?>