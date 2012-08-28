<?php

/**
 * Models for XirtCMS Menu Items
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MenuItemsModel extends XTree {

   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__menunodes';


   /**
    * Loads list information from the database
    *
    * @param $iso The language to load (e.g. 'en-GB')
    * @param $xId The xId of the menu to load
    * @return boolean True on succes, false on failure
    */
   public function load($iso = null, $xId = 0) {
      return ($this->_table ? !$this->_load($iso, $xId) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @access protected
    * @param $iso The language to load (e.g. 'en-GB')
    * @param $xId The xId of the menu to load
    */
   protected function _load($iso = null, $xId = 0) {
      global $xConf, $xDb;

      $languages = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languages) ? $iso : $xConf->language;
      $iso = intval($languages[$iso]->preference);

      // Query (selection)
      $query = 'SELECT id, xid, parent_id, name, ordering, language, ' .
               '       published, sitemap, mobile, home, preference  ' .
               'FROM (%s) AS subset                                  ' .
               'GROUP BY xid                                         ' .
               'ORDER BY level ASC, ordering DESC                    ';

      // Subquery (translations)
      $subset = 'SELECT t1.*, t2.preference                          ' .
                'FROM %s AS t1                                       ' .
                'INNER JOIN #__languages AS t2                       ' .
                'ON t1.language = t2.iso                             ' .
                'WHERE menu_id = :xId                                ' .
                'ORDER BY replace(t2.preference, :iso, 0)            ';
      $subset = sprintf($subset, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $subset));
      $stmt->bindParam(':iso', $iso, PDO::PARAM_STR);
      $stmt->bindParam(':xId', $xId, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         parent::add(new XNode($dbRow));
      }

   }

}
?>