<?php

/**
 * Models for Usergroups
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UsergroupsModel extends XContentList {

   /**
    * @var String Table with item information
    */
   protected $_table = '#__usergroups';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'rank';


   /**
    * @var Array The list of columns used for every item
    */
   protected $_columns = array('rank', 'name');


   /**
    * Initializes Model with requested values
    */
   function __construct() {

      $this->setStart(XTools::getParam('start', 0, _INT));
      $this->setLimit(XTools::getParam('limit', 999, _INT));
      $this->setOrder(XTools::getParam('order', 'DESC', _STRING));
      $this->setColumn(XTools::getParam('column', 'id', _STRING));

   }


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

      $languageList = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languageList) ? $iso : $xConf->language;
      $iso = intval($languageList[$iso]->preference);

      // Query (selection)
      $query = 'SELECT *                                                     ' .
               'FROM (%%s) AS subset                                         ' .
               'GROUP BY rank                                                ' .
               'ORDER BY %s %s                                               ';
      $query = sprintf($query, $this->_column, $this->_order);

      // Subquery (translations)
      $trans = 'SELECT t1.*, t2.preference                                   ' .
               'FROM %s AS t1                                                ' .
               'INNER JOIN #__languages AS t2                                ' .
               'ON t1.language = t2.iso                                      ' .
               'ORDER BY replace(t2.preference, :iso, 0)                     ';
      $trans = sprintf($trans, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(':iso', $iso, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new XItemModel($dbRow), false);
      }

   }

}
?>