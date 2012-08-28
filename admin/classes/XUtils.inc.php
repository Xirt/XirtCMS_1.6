<?php

/**
 * Utility class for Managers
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XUtils {

   /**
    * @var The path to the modules
    */
   const PATH_MODULES = '%smodules/';


   /**
    * Returns list with available languages
    *
    * @return Array containing the available languages
    */
   public static function getLanguageList() {

      $list = array();
      foreach (Xirt::getLanguages() as $iso => $language) {
         $list[$iso] = $language->name;
      }

      return $list;
   }


   /**
    * Returns list with available ranks
    *
    * @return Array containing the available ranks
    */
   public static function getRankList() {

      $list = array();
      foreach (Xirt::getRanks() as $rank => $rankInfo) {
         $list[$rank] = $rankInfo->name;
      }

      return $list;
   }


   /**
    * Returns a list of all available menus
    *
    * @return Array All available menus
    */
   public static function getMenuList() {
      global $xDb;

      $list = array();
      foreach (Xirt::getMenus() as $menu) {
         $list[$menu->xid] = $menu->title;
      }

      return $list;
   }


   /**
    * Returns list with available positions (on templates)
    *
    * @return Array containing the available positions
    */
   public static function getPositionList() {
      global $xDb;

      $stmt = $xDb->prepare("SELECT positions FROM #__templates");
      $stmt->execute();

      $list = array();
      while ($template = $stmt->fetchObject()) {

         foreach (explode('|', $template->positions) as $position) {

            if (($position = trim($position)) && $position) {
               $list[$position] = $position;
            }

         }

      }

      return $list;
   }


   /**
    * Returns list with available modules
    *
    * @return Array containing the available modules
    */
   public static function getModuleList() {
      global $xConf;

      $list = array();
      $path  = sprintf(XUtils::PATH_MODULES, $xConf->baseDir);

      if (!$handle = @opendir($path)) {

         trigger_error("[XUtils] Modules unavailable.", E_USER_WARNING);
         return $list;

      }

      while (($subdir = @readdir($handle)) !== false) {

         if (!is_dir($path . $subdir)) {
            continue;
         }

         $file = $subdir . '/index.mod.xml';
         if (!is_readable($path . $file)) {
            continue;
         }

         try { $moduleInfo = new SimpleXMLElement($path . $file, null, true); }
         catch (Exception $e) {
            trigger_error("[XUtils] XML Failure ({$subdir}).", E_USER_WARNING);
         }

         if (!isset($moduleInfo->name)) {
            continue;
         }

         $list[$subdir] = $moduleInfo->name;
      }

      @closedir($handle);
      return $list;
   }


   /**
    * Returns list with all menuitems (pages)
    *
    * @param $showAllPages Toggles showing the option 'all pages'
    * @param $showUnassigned Toggles showing the option 'unassigned'
    * @return Array containing all menuitems
    */
   public static function getPageList($showAllPages = 0, $showUnassigned = 0) {
      global $xLang;

      $list = array();

      if ($showAllPages) {
         $list['all'] = $xLang->misc['optionAllPages'];
      }

      if ($showUnassigned) {
         $list['undef'] = $xLang->misc['optionUnassigned'];
      }

      // Add items from every menu...
      $menus = XUtils::getMenuList();
      foreach($menus as $id => $menu) {

         if ($id - 1 < count($menus)) {
            $list['-' . $id] = '---';
         }

         // Add menu entries
         $menu = new XMenu($id, null);
         $menu->load();

         foreach($menu->toArray() as $node) {

            $indent =  XUtils::createIndent($node->level);
            $node->name = $indent . $node->name;
            $list[$node->xid] = $node->name;

         }

      }

      return $list;
   }


   /**
    * Returns a String for indentation
    *
    * @param $indent The level of indentation
    * @return The String for indentation
    */
   public static function createIndent($length) {

      for ($i = 0; $i < $length * 3; $i++) {
         $indent = (isset($indent) ? $indent : '') . '&nbsp;';
      }

      return $indent;
   }

}
?>