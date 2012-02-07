<?php

/**
 * Extended version of XTree to add extra menu functionality
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        XTree
 */
class XMenu extends XTree {

   /**
    * CONSTRUCTOR (overrides XTree constructor)
    *
    * @param $id The ID of the menu
    * @param $title The title of the menu (optional, defaults null)
    */
   function __construct($id, $title = null) {
      global $xPage;

      $this->id    = $id;
      $this->title = $title;
      $this->cache = 'menu_' . $id;
      $this->cId   = $xPage->cId;

   }


   /**
    * Loads the menu
    */
   public function load() {
      global $xDb, $xCache;

      // Retrieve cache
      $menu = $this->cache;
      if (isset($xCache->$menu)) {
         return ($this->children = $xCache->$menu->children);
      }

      // Database
      foreach ($this->_getNodes() as $nodeInfo) {
         $this->add(new XMenuNode($nodeInfo));
      }

      $this->activate();

      // Cache menu
      $menu = $this->cache;
      $xCache->$menu = clone $this;

   }


   /**
    * Return all published nodes
    *
    * @access private
    * @return Array Containing all published nodes
    */
   private function _getNodes() {
      global $xConf, $xDb, $xUser;

      $languages = Xirt::getLanguages();
      $published = defined('_XADMIN') ? '?' : '1';
      $iso = $languages[$xConf->language]->preference;

      // Query (selection)
      $query = 'SELECT *                                              ' .
                'FROM (%s) AS subset                                  ' .
                'WHERE menu_id = :id                                  ' .
                '  AND published = :published                         ' .
                '  AND access_min <= :rank                            ' .
                '  AND access_max >= :rank                            ' .
                'GROUP BY xid                                         ' .
                'ORDER BY parent_id ASC, xid ASC                      ';

      // Subquery (translations)
      $trans = 'SELECT t1.*, t2.preference                            ' .
               'FROM #__menunodes AS t1                               ' .
               'INNER JOIN #__languages AS t2 ON t1.language = t2.iso ' .
               'ORDER BY replace(t2.preference, :iso, 0)              ';

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(':published', $published, PDO::PARAM_INT);
      $stmt->bindParam(':rank', $xUser->rank, PDO::PARAM_INT);
      $stmt->bindParam(':iso', $iso, PDO::PARAM_STR);
      $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
   }


   /**
    * Turns current item into active item
    *
    * @access protected
    */
   protected function activate() {

      if ($node = $this->getItemById($this->cId)) {
         if (isset($node->link)) {
            $this->setActiveByLink($node->link);
         }

         return $node->setActive();
      }

      $this->setActiveByLink('index.php?' . $_SERVER['QUERY_STRING']);

   }


   /**
    * Dummy method to stop activation process
    *
    * @return boolean true
    */
   public function setActive() {
      return true;
   }


   /**
    * Search depth-first for MenuItem for the given link and activate it
    *
    * @param $link The link (of the active item) to search for
    */
   public function setActiveByLink($link) {

      foreach ($this->children as $child) {
         $child->setActiveByLink($link);
      }

   }

}
?>