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
   var $table = "#__content_categories";


   /**
    * Loads all menu items from the database and adds them to the list
    *
    * @param $iso The language to load (e.g. 'en-GB')
    */
   public function load($iso = null) {
      global $xConf, $xDb;

      $languageList = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languageList) ? $iso : $xConf->language;
      $iso = intval($languageList[$iso]->preference);

      $query = "SELECT
                   id, xid, parent_id, name, ordering, language,
                   published, sitemap, mobile, preference
                FROM (
                   SELECT t1.*, t2.preference
                   FROM {$this->table} AS t1
                   INNER JOIN #__languages AS t2 ON t1.language = t2.iso
                   ORDER BY replace(t2.preference, {$iso}, 0)
                ) AS t3
                GROUP BY xid
                ORDER BY level ASC, ordering DESC";
      $xDb->setQuery($query);

      foreach ($xDb->loadObjectList() as $dbRow) {
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
      $xDb->insert($this->table, XTools::addslashes($node));

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

      foreach (array_reverse($current->parent->children) as $child) {

         if ($child->ordering < $current->ordering) {
            break;
         }

      }

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

      foreach ($current->parent->children as $child) {

         if ($child->ordering > $current->ordering) {
            break;
         }

      }

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

      $query = "SELECT MAX({$attrib})
                FROM {$this->table}";
      $xDb->setQuery($query);

      return intval($xDb->loadResult());
   }


   /**
    * Returns the maximum ordering in use for the given level (by node)
    *
    * @access private
    * @return int Maximum ordering found or 0
    */
   private function _getMaxOrdering($item) {
      global $xDb;

      $query = "SELECT MAX(ordering)
                FROM {$this->table}
                WHERE parent_id = '{$item->parent_id}'";
      $xDb->setQuery($query);

      return intval($xDb->loadResult());
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode($noDuplicates = false) {

      return json_encode($this->getList());
   }

}
?>