<?php

/**
 * Manager for XirtCMS languages
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentManager {

   /**
    * Move item up
    */
   public static function moveUp() {

      $list = new LanguageList();
      $list->load();
      $list->moveUp(XTools::getParam('id', 0, _INT));

   }


   /**
    * Move item down
    */
   public static function moveDown() {

      $list = new LanguageList();
      $list->load();
      $list->moveDown(XTools::getParam('id', 0, _INT));

   }


   /**
    * Toggles publication status of an item
    */
   public static function toggleStatus() {

      $item = new Language();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleStatus();

   }

}
?>