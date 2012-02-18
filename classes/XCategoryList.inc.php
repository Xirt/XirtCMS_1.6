<?php

/**
 * List containing all content categories
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XCategoryList {

   /**
    * @var The list of items (XTree-structure)
    */
   var $_list = null;


   /**
    * Constructor (empty)
    */
   function __construct() {
      $this->_list = new XTree();
   }


   /**
    * Loads all categories from the database
    *
    * @param $iso The language to load (optional)
    */
   public function load($iso = null) {
      global $xConf, $xDb;

      $languageList = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languageList) ? $iso : $xConf->language;
      $iso = intval($languageList[$iso]->preference);

      // Query (selection)
      $query = 'SELECT id, xid, parent_id, name, ordering, language   ' .
                'FROM (%s) AS subset                                  ' .
                'GROUP BY xid                                         ' .
                'ORDER BY level ASC, ordering DESC                    ';

      // Subquery (translations)
      $trans = 'SELECT t1.*                                           ' .
               'FROM #__content_categories AS t1                      ' .
               'INNER JOIN #__languages AS t2 ON t1.language = t2.iso ' .
               'ORDER BY replace(t2.preference, :iso, 0)              ';

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(':iso', $iso, PDO::PARAM_STR);
      $stmt->execute();

      // Populate object
      while ($dbRow = $stmt->fetchObject()) {
         $this->_list->add(new XNode($dbRow));
      }

   }


   /**
    * Returns the categories as Array
    *
    * @return Array The categories
    */
   public function toArray() {
      return $this->_list->toArray();
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this->toArray());
   }


   /**
    * Shows list as JSON Object
    */
   public function show() {

      header('Content-type: application/x-json');
      die($this->encode());

   }

}
?>