<?php

/**
 * Models for XirtCMS Categories
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class CategoriesModel extends XTree {

   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__content_categories';


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
    * @access protected
    * @param $iso The language to load (e.g. 'en-GB')
    */
   protected function _load($iso = null) {
      global $xConf, $xDb;

      $languages = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languages) ? $iso : $xConf->language;
      $iso = intval($languages[$iso]->preference);

      // Query (selection)
      $query = 'SELECT id, xid, parent_id, name, ordering, language, ' .
               '       published, sitemap, mobile, preference        ' .
               'FROM (%s) AS subset                                  ' .
               'GROUP BY xid                                         ' .
               'ORDER BY level ASC, ordering DESC                    ';

      // Subquery (translations)
      $trans = 'SELECT t1.*, preference                              ' .
               'FROM %s AS t1                                        ' .
               'INNER JOIN #__languages AS t2                        ' .
               'ON t1.language = t2.iso                              ' .
               'ORDER BY replace(t2.preference, :iso, 0)             ';
      $subset = sprintf($trans, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $subset));
      $stmt->bindParam(':iso', $iso, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         parent::add(new XNode($dbRow));
      }

   }

}
?>