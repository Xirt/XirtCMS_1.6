<?php

/**
 * Model for the management panel
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class PanelModel extends XComponentModel {

   /**
    * @var The base URL to a single content item (front-end)
    */
   const URI_CATEGORY = "index.php?content=com_category&amp;id=%d";


   /**
    * @var The base URL to a single content item (front-end)
    */
   const URI_COMPONENT = "index.php?content=%s";


   /**
    * Method to load data
    */
   public function load() {

      $this->_includeID();
      $this->_includeRanks();
      $this->_includeTitle();
      $this->_includeContents();
      $this->_includeLanguages();
      $this->_includeComponents();
      $this->_includeCategories();

   }


   /**
    * Includes the xId of the current menu
    *
    * @access protected
    */
   private function _includeID() {
      $this->xId = XTools::getParam('menu_id', 0, _INT);
   }


   /**
    * Includes a list of all available content items
    *
    * @access protected
    */
   private function _includeContents() {

      $this->contents = new ContentsModel($this->xId);
      $this->contents->load();

   }


   /**
    * Includes a list of all available components
    *
    * @access protected
    */
   private function _includeComponents() {

      $this->components = array();
      foreach (Xirt::getComponents() as $type => $component) {

         $uri = sprintf(self::URI_COMPONENT, $type);
         $this->components[$uri] = $component->name;

      }

   }


   /**
    * Includes a list of all available categories
    *
    * @access protected
    */
   private function _includeCategories() {

      // TODO :: Use a CategoryModel
      $categories = new XCategoryList();
      $categories->load();

      // Add categories to list
      $this->categories = array();
      foreach ($categories->toArray() as $category) {

         $link = sprintf(self::URI_CATEGORY, $category->xid);
         $this->categories[$link] = $category->name;

      }

   }


   /**
    * Includes the current menu title
    *
    * @access protected
    */
   private function _includeTitle() {
      global $xDb;

      // Database query
      $query = 'SELECT title FROM #__menus WHERE xid = :xId';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(':xId', $this->xId, PDO::PARAM_INT);
      $stmt->execute();

      if (!$this->title = $stmt->fetchColumn()) {
         header('Location: index.php?content=adm_menus');
      }

   }

}
?>