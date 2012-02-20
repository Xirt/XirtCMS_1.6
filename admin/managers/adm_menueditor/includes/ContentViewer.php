<?php

/**
 * Viewer for XirtCMS menu nodes
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentViewer {

   /**
    * @var The base URL to a single content item (front-end)
    */
   const URI_CATEGORY = "index.php?content=com_category&amp;id=%d";


   /**
    * @var The base URL to a single content item (front-end)
    */
   const URI_COMPONENT = "index.php?content=%s";


   /**
    * Shows the main screen
    */
   public static function showTemplate() {
      global $xCom, $xDb, $xLang;

      // Retrieve menu title
      $id = XTools::getParam('menu_id', 0, _INT);

      if (!$title = ContentViewer::_getMenuTitle($id)) {
         header('Location: index.php?content=adm_menus');
      }

      // Show template
      $tpl = new XAdminTemplate('adm_menueditor');
      $tpl->assign('xLang',        $xCom->xLang);
      $tpl->assign('xMainLang',    $xLang);
      $tpl->assign('menuTitle',    $title);
      $tpl->assign('menuId',       $id);
      $tpl->assign('ranks',        XUtils::getRankList());
      $tpl->assign('languages',    XUtils::getLanguageList());
      $tpl->assign('contents',     ContentViewer::_getContent());
      $tpl->assign('categories',   ContentViewer::_getCategories());
      $tpl->assign('components',   ContentViewer::_getComponents());
      $tpl->display('main.tpl');

   }

   /**
    * Shows a JSON list of all content
    */
   public static function showContentList() {
      global $xConf;

      $list = new ContentList(XTools::getParam('menu_id', 0, _INT));
      $list->load(XTools::getParam('iso'));
      $list->show();

   }

   /**
    * Shows a JSON object containing details about an item
    *
    * @param $id Integer of item to load (optional)
    */
   public static function showItem($id = 0) {

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new Translation();
      $item->load($id);
      $item->show();

   }



   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns the menu title (main language) for a menu
    *
    * @access protected
    * @param $xId Integer with xId of the requested menu
    * @return mixed The name of the menu or false on failure
    */
   protected static function _getMenuTitle($xId) {
      global $xDb;

      // Database query
      $query = 'SELECT title FROM #__menus WHERE xid = :id';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(':id', $xId, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchColumn();
   }


   /**
    * Returns a list with links to all static content
    *
    * @access protected
    * @return Array List with static content items (uri => name)
    */
   protected static function _getContent() {
      global $xDb;

      $list = self::_getCategoryList();

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

         foreach ($list as $category) {

            if ($category->id == $content->category) {

               $category->add($content);
               continue 2;

            }

         }

         $list[0]->add($content);

      }

      return $list;
   }


   /**
    * Returns a list with links to all dynamic content categories
    *
    * @access protected
    * @return Array List with dynamic content categories (uri => name)
    */
   protected static function _getCategories() {

      $list = array();

      $categories = new XCategoryList();
      $categories->load();

      foreach ($categories->toArray() as $category) {

         $link = sprintf(self::URI_CATEGORY, $category->xid);
         $list[$link] = $category->name;

      }

      return $list;
   }


   /**
    * Returns a list with links to all dynamic content categories
    *
    * @access protected
    * @return Array List with dynamic content categories (uri => name)
    */
   protected static function _getCategoryList() {
      global $xCom;

      $categories = new XCategoryList();
      $categories->load();

      $list = array();
      $list[] = new Category(-1, $xCom->xLang->misc['noCategory']);

      foreach ($categories->toArray() as $category) {
         $list[] = new Category($category->xid, $category->name);
      }

      return $list;
   }


   /**
    * Returns a list with links to components
    *
    * @access protected
    * @return Array List with components (uri => name)
    */
   protected static function _getComponents() {

      $list = array();

      foreach (Xirt::getComponents() as $type => $component) {
         $list[self::URI_COMPONENT . $type] = $component->name;
      }

      return $list;
   }

}
?>