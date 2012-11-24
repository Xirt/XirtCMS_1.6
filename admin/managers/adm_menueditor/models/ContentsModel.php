<?php

/**
 * Model for XirtCMS Content (grouped by  XirtCMS Content Category)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentsModel extends XContentList {

   /**
    * Initialize empty ContentsModel
    */
   public function __construct() {

      $this->_list = self::_getCategoryList();
      parent::__construct();

   }

   /**
    * Method to load data
    */
   public function load() {
      global $xDb;

      // Query (selection)
      $query = 'SELECT xid, category, title    ' .
               'FROM (%%s) AS subset           ' .
               'GROUP BY xid                   ' .
               'ORDER BY title                 ';
      $query = sprintf($query);

      // Subquery (translations)
      $subset = 'SELECT t1.*, t2.preference    ' .
                'FROM #__content AS t1         ' .
                'INNER JOIN #__languages AS t2 ' .
                'ON t1.language = t2.iso       ' .
                'ORDER BY t2.preference, t1.xid';

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $subset));
      $stmt->execute();

      // Populate category list with content
      while ($content = $stmt->fetchObject()) {

         foreach ($this->_list as $category) {

            if ($category->id == $content->category) {

               $category->add($content);
               continue 2;

            }

         }

         $this->_list[0]->add($content);

      }

      return $this->_list;
   }


   /**
    * Returns a list with links to all dynamic content categories
    *
    * @access private
    * @return Array List with dynamic content categories (uri => name)
    */
   private static function _getCategoryList() {
      global $xCom;

      // Create list
      $list = array();
      $list[] = new CategoryModel(-1, $xCom->xLang->misc['noCategory']);

      // And add all categories
      $categories = new XCategoryList();
      $categories->load();

      foreach ($categories->toArray() as $category) {
         $list[] = new CategoryModel($category->xid, $category->name);
      }

      return $list;
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this->toArray());
   }

}
?>