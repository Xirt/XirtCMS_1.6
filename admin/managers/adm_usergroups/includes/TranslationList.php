<?php

/**
 * List containing simple instances of Translation (XirtCMS usergroups)
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
   var $table = '#__usergroups';


   /**
    * Loads list information from the database
    * NOTE: This method is required to call the _new_ method $this->_load();
    *
    * @param xId Integer with the xId of the items in the list
    * @return boolean True on succes, false on failure
    */
   public function load($xId) {
      return ($this->table ? !$this->_load($xId) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @access private
    * @param $rank The rank of the item in the database
    */
   private function _load($rank) {
      global $xDb;

      // Query (selection)
      $query = 'SELECT *                       ' .
               'FROM (%s) AS subset            ' .
               'WHERE rank = :rank             ';

      // Subquery (translations)
      $trans = 'SELECT t1.*                    ' .
               'FROM %s AS t1                  ' .
               'INNER JOIN #__languages AS t2  ' .
               'ON t1.language = t2.iso        ' .
               'ORDER BY t2.preference, t1.rank';
      $subset = sprintf($trans, $this->table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $subset));
      $stmt->bindParam(':rank', $rank, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new Translation($dbRow), false);
      }

   }

}
?>