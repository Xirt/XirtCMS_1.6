<?php

/**
 * Library to show the Sitemap
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Viewer {

   /**
    * Shows the sitemap in HTML
    */
   public static function showSitemap() {
      global $xCom;

      $tpl = new Template();
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('menuList', self::getLinks());
      $tpl->display('html.tpl');

   }


   /**
    * Shows the sitemap in XML
    */
   public static function showSitemapUseXML() {
      global $xConf;

      // Hide defaults
      $xConf->hideTemplate();
      header('Content-type: application/xml; charset="utf-8"');

      // Gather all nodes in Array
      $nodes = array();
      foreach (self::getLinks() as $menu) {
         $nodes = array_merge($nodes, $menu->toArray());
      }

      // Show template
      $tpl = new Template();
      $tpl->assign('xConf', $xConf);
      $tpl->assign('nodes', self::_filter($nodes));
      $tpl->display('xml.tpl');

   }


   /**
    * Returns all XMenus with links for the sitemap
    *
    * @access private
    * @return Array with all required XMenus
    */
   private static function getLinks() {

      $list = array();
      foreach (Xirt::getMenus() as $menu) {

         if ($menu->sitemap) {

            $menu = new XMenu($menu->xid, $menu->title);
            $menu->load();

            self::_link($menu);
            $list[] = $menu;

         }

      }

      return $list;
   }


   /**
    * Replaces database links in given XMenu with usable (SEF) links
    *
    * @access private
    * @param $node The node to modify
    */
   private static function _link($node) {

      foreach ($node->children as $key => $child) {

         // Skip hidden items / non-regular links
         if (!$child->sitemap || !in_array($child->link_type, array(0, 1, 2))) {

            unset($node->children[$key]);
            continue;

         }

         // Update links
         $child->link = XTools::createLink(
            $child->link,
            $child->xid,
            $child->name
         );

         self::_link($child);

      }

   }


   /**
    * Filters the given array (removes items with identical links)
    *
    * @access private
    * @param $array The array to filter
    * return Array The filtered array
    */
   private static function _filter($array) {

      foreach ($array as $key => $item) {

         foreach ($array as $key2 => $item2) {

            if ($item->link == $item2->link && $key != $key2) {

               unset($array[$key]);
               break;

            }

         }

      }

      return $array;
   }

}
?>