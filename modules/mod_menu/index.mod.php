<?php

require_once('MenuLink.php');

/**
 * This module shows a menu with defined specifications
 * TODO: Rewrite using Object Oriented approach
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class mod_menu extends XModule {

   /**
    * Handles any normal requests
    */
   public function showNormal() {

      if (!$this->xConf->menu_id) {
         return trigger_error("Unknown menu in 'mod_menu'.", E_USER_WARNING);
      }

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('xMod', $this);
      $tpl->display('template.tpl');

   }


   /**
    * Handles any mobile requests
    */
   function showMobile() {
      $this->showNormal();
   }


   /**
    * Shows the chosen menu style
    */
   public function show() {

      $menu = new XMenu($this->xConf->menu_id);
      $menu->load();

      switch ($this->xConf->show_type) {

         case 1:
            $this->displayFlatList($menu->getTree());
            break;

         case 2:
            $this->displayDivList($menu->toArray());
            break;

         default:
            $this->displayPlainLinks($menu->toArray());
            break;

      }

   }


   /**
    * Draws menu with flat links using recursion
    *
    * @access private
    * @param $menu The menu as a list (Array)
    */
   private function displayPlainLinks($menu) {

      $xConf = $this->xConf;

      // Draw separator (start)
      if ($xConf->separator_style == 2) {
         print(nl. $xConf->separator);
      }

      $print = false;
      foreach ($menu as $node) {

         // Draw separators
         if ($print && $xConf->separator_style != 0) {
            print($xConf->separator);
         }

         if ($node->level < $xConf->level_start + 1) {
            $print = false;
            continue;
         }

         if ($node->level > $xConf->level_end + 1) {
            $print = false;
            continue;
         }

         if ($xConf->parent_id == $node->parent_id || !$xConf->parent_id
            || $print) {

            $item = new MenuLink($node, $xConf);
            $item->show();

            $print = true;

         }

      }

      // Draw separator (end)
      if ($xConf->separator_style == 2) {
         print(nl. $xConf->separator);
      }

   }

   /**
    * Draws a menu as a flat list (using recursion)
    *
    * @access private
    * @param $menu The menu as a tree
    */
   private function displayFlatList($menu, $oEcho = false) {

      // No children, return
      if (!$mchildren = $menu->children) {
         return;
      }

      // Top level, start menu
      if ($menu->level == 0) {
         print("<ul>");
      }

      // Start current level, draw separator
      $xConf = $this->xConf;
      $oEcho = (!$xConf->parent_id) ? true : $oEcho;

      if ($oEcho && $xConf->separator_style == 2) {

         print("<li class='separator" . current($mchildren)->css_name . "'>");
         print($xConf->separator);
         print("</li>");

      }

      foreach ($mchildren as $key => $node) {

         // Search for parentID
         $cEcho = ($xConf->parent_id == $node->xid) ? true : $oEcho;

         // Item not displayed, continue
         if ($node->level < $xConf->level_start + 1) {
            $this->displayFlatList($node, $cEcho);
            continue;
         }

         // Item not displayed, continue
         if (!$cEcho) {
            $this->displayFlatList($node);
            continue;
         }

         // Display separator (optional)
         if ($key && $xConf->separator_style != 0) {
            print("<li class='separator{$node->css_name}'>");
            print($xConf->separator);
            print("</li>");
         }

         // Display current item
         $item = new MenuLink($node, $xConf);

         print("<li class='{$node->css_name}'>");
         $item->show();

         // Display children
         if ($node->children && $node->level != $xConf->level_end + 1) {
            print("<ul>");
            $this->displayFlatList($node, $cEcho);
            print("</ul>");
         }

         print("</li>");
      }

      // End current level, draw separator
      if ($oEcho && $xConf->separator_style == 2) {
         print("<li class='separator" . $node->css_name . "'>");
         print($xConf->separator);
         print("</li>");
      }

      // Top level, end menu
      if ($menu->level == 0) {
         print("</ul>");
      }
   }


   /**
    * Draws menu with links in DIV-containers (does not use seperators)
    *
    * @access private
    * @param $menu The menu as a list (Array)
    */
   private function displayDivList($menu) {

      $print = false;
      $xConf = $this->xConf;

      foreach ($menu as $node) {

         if ($node->level < $xConf->level_start + 1) {

            $print = false;
            continue;

         }

         if ($node->level > $xConf->level_end + 1) {
            $print = false;
            continue;
         }

         if ($xConf->parent_id == $node->parent_id || !$xConf->parent_id
            || $print) {

            print("<div class='{$node->css_name}'>");
            $item = new MenuLink($node, $xConf);
            $item->show();
            print("</div>");

            $print = true;
         }

      }

   }

}
?>
