<?php

/**
 * List containing instances of XItem (XirtCMS static content)
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
   protected $_table = '#__content';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'title';


   /**
    * @var Array The list of columns used for every item
    */
   protected $_columns = array('xid', 'title', 'category');


   /**
    * Loads list information from the database
    *
    * @param $iso The language to load (e.g. 'en-GB')
    * @return boolean True on succes, false on failure
    */
   public function load($iso = null) {
      return ($this->_table ? !$this->_load($iso) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @access private
    * @param $iso The language to load (e.g. 'en-GB')
    */
   private function _load($iso = null) {
      global $xConf, $xDb;

      $languages = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languages) ? $iso : $xConf->language;
      $iso = intval($languages[$iso]->preference);

      // Query (selection)
      $query = 'SELECT id, xid, category, title, language, ' .
               '       author_name, published, mobile      ' .
               'FROM (%%s) AS subset                       ' .
               'GROUP BY xid                               ' .
               'ORDER BY %s %s                             ';
      $query = sprintf($query, $this->_column, $this->_order);

      // Subquery (translations)
      $trans = 'SELECT t1.*, t2.preference                 ' .
               'FROM %s AS t1                              ' .
               'INNER JOIN #__languages AS t2              ' .
               'ON t1.language = t2.iso                    ' .
               'ORDER BY replace(t2.preference, :iso, 0)   ';
      $trans = sprintf($trans, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(':iso', $iso, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new XItem($dbRow), false);
      }

   }


   /**
    * Adds an item
    *
    * @param $item The item to add
    * @return boolean True
    */
   public function add($item) {

      $item->set('config', json_encode($item->config));
      $item->set('id', null, true);

      return $this->_add($item);
   }

}
?>