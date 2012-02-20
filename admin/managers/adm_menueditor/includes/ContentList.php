<?php

/**
 * List containing menu noedes for given menu (using XTree / XNode)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        XTree
 * @see        XNode
 */
class ContentList extends XTree {

   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__menunodes';


   /**
    * CONSTRUCTOR
    *
    * @param $menu Integer with the menu ID
    */
   function __construct() {
      $this->menu_id = func_get_arg(0);
   }


   /**
    * Loads all menu items from the database and adds them to the list
    *
    * @param $iso The language to load (e.g. 'en-GB')
    */
   function load($iso = null) {
      global $xConf, $xDb;

      $languageList = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languageList) ? $iso : $xConf->language;
      $iso = intval($languageList[$iso]->preference);

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
                'WHERE menu_id = :menu_id                            ' .
                'ORDER BY replace(t2.preference, :iso, 0)            ';
      $subset = sprintf($subset, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $subset));
      $stmt->bindParam(':iso', $iso, PDO::PARAM_STR);
      $stmt->bindParam(':menu_id', $this->menu_id, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         parent::add(new Translation($dbRow));
      }

   }


   /****************/
   /*  MODIFY (DB) */
   /****************/

   /**
    * Adds item
    *
    * @param $node Node that needs to be added to the list
    */
   public function add(&$node) {
      global $xDb;

      $node->set('children', null, true);
      $node->set('ordering', $this->_getMaxOrdering($node) + 1);
      $xDb->insert($this->_table, XTools::addslashes($node));

   }


   /**
    * Moves all translations of an item up
    *
    * @param $id The ID of the node to move up
    */
   public function moveUp($id) {

      if (!$current = $this->getItemById($id)) {
         return false;
      }

      // Search for direct neightbour
      foreach (array_reverse($current->parent->children) as $child) {

         if ($child->ordering < $current->ordering) {
            break;
         }

      }

      // Save changes
      $item = new TranslationList();
      $item->load($current->xid);
      $item->setOrdering($child->ordering);

      $item = new TranslationList();
      $item->load($child->xid);
      $item->setOrdering($current->ordering);

   }


   /**
    * Moves all translations of an item down
    *
    * @param $id The ID of the node to move down
    */
   public function moveDown($id) {

      if (!$current = $this->getItemById($id)) {
         return false;
      }

      // Search for direct neightbour
      foreach ($current->parent->children as $child) {

         if ($child->ordering > $current->ordering) {
            break;
         }

      }

      // Save changes
      $item = new TranslationList();
      $item->load($child->xid);
      $item->setOrdering($current->ordering);

      $item = new TranslationList();
      $item->load($current->xid);
      $item->setOrdering($child->ordering);

   }



   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns the maximum value of the given attribute
    *
    * @param $attrib The attrib to get the maximum value of (default: xid)
    * @return int Maximum value found or 0
    */
   public function getMaximum($attrib = 'xid') {
      global $xDb;

      // Database query
      $query = 'SELECT MAX(%s) ' .
      			'FROM %s        ';
      $query = sprintf($query, $attrib, $this->_table);

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      return intval($stmt->fetchColumn());
   }


   /**
    * Returns the maximum ordering in use for the given level (by node)
    *
    * @access private
    * @return int Maximum ordering found or 0
    */
   private function _getMaxOrdering($item) {
      global $xDb;

      // Database query
      $query = 'SELECT MAX(ordering)        ' .
      			'FROM %s                     ' .
      			'WHERE parent_id = :parent_id';
      $query = sprintf($query, $this->_table);

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $item->parent_id, PDO::PARAM_INT);
      $stmt->execute();

      return intval($stmt->fetchColumn());
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode($noDuplicates = false) {
      return json_encode($this->toArray());
   }

}
?>