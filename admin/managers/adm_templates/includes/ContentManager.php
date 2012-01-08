<?php

/**
 * Manager for XirtCMS templates
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentManager {

   /**
    * Adds item
    */
   public static function addItem() {
      global $xCom;

      $item = new Template();
      $item->set('name',   XTools::getParam('nx_name'));
      $item->set('folder', XTools::getParam('nx_folder'));

      if ($item->create()) {
         $list = new TemplateList();
         $list->add($item);
      }

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xCom;

      $folder = XTools::getParam('x_folder');

      $item = new Template();
      $item->load(XTools::getParam('id', 0, _INT));

      if ($item->relocate($folder)) {

         $item->set('folder', $folder);
         $item->set('name',   XTools::getParam('x_name'));
         $item->set('pages',  sprintf('|%s|', XTools::getParam('x_pages')));

         $item->save();

      }

   }


   /**
    * Edits configurations
    */
   public static function editConfiguration() {

      $positions = XTools::getParam('x_positions');

      $item = new Template();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->set('positions', sprintf('|%s|', $positions));
      $item->save();

   }


   /**
    * Toggles publication status of an item
    */
   public static function toggleStatus() {

      $item = new Template();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleStatus();

   }


   /**
    * Toggles default item (unpublished / published)
    */
   public static function toggleActive() {

      $item = new Template();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleActive();

   }


   /**
    * Removes item
    */
   public static function removeItem() {
      global $xCom, $xLang;

      $item = new Template();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->remove();

   }

}
?>