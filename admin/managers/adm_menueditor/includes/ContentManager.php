<?php

/**
 * Manager for XirtCMS menu nodes
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

      $list = new ContentList(XTools::getParam('menu_id', 0, _INT));
      $list->load(XTools::getParam('nx_language'));

      // Retrieve parent node
      $parent = XTools::getParam('nx_parent_id', 0, _INT);
      if (!$parent = $list->getItemById($parent)) {
         return false;
      }

      $item = new Translation();
      $item->set('menu_id',   $list->menu_id);
      $item->set('xid',       $list->getMaximum('xid') + 1);
      $item->set('parent_id', $parent->xid);
      $item->set('level',     $parent->level + 1);
      $item->set('name',      XTools::getParam('nx_name'));
      $item->set('language',  XTools::getParam('nx_language'));

      $list->add($item);

   }


   /**
    * Adds translation
    */
   public static function addTranslation() {
      global $xCom, $xDb, $xUser;

      $list = new TranslationList();
      $list->load(XTools::getParam('xid', 0, _INT));

      // Create from best translation
      $iso = XTools::getParam('language');
      foreach ($list->toArray() as $candidate) {

         if ($candidate->language != $iso) {

            $item = new Translation();
            $item->load($candidate->id);

            $item->set('id', null,  true);
            $item->set('published', 0);
            $item->set('language',  $iso);
            $item->set('name',      $item->name . '*');

            return $list->add($item);
         }

      }

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xUser;

      // Change name
      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->set('name', XTools::getParam('x_name'));
      $item->save();

      // Change parent
      $list = new TranslationList();
      $list->load($item->xid);
      $list->setparent(XTools::getParam('x_parent_id', 0, _INT));

   }


   /**
    * Edits configuration
    */
   public static function editConfiguration() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $items = array($item);

      if (XTools::getParam('affect_all')) {

         $list = new TranslationList();
         $list->load(XTools::getParam('xid', 0, _INT));
         $items = $list->toArray();

      }

      foreach ($items as $item) {

         $item->set('css_name',  XTools::getParam('x_css_name'));
         $item->set('image',     XTools::getParam('x_image'));
         $item->set('link_type', XTools::getParam('x_link_type'));
         $item->set('link',      XTools::getParam('x_link'));

         $item->save();

      }

   }


   /**
    * Edits access
    */
   public static function editAccess() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $items = array($item);

      if (XTools::getParam('affect_all')) {

         $list = new TranslationList();
         $list->load(XTools::getParam('xid', 0, _INT));
         $items = $list->toArray();

      }

      foreach ($items as $item) {

         $item->set('access_min', XTools::getParam('access_min', 0, _INT));
         $item->set('access_max', XTools::getParam('access_max', 0, _INT));
         $item->save();

      }

   }


   /**
    * Moves all translations of an item up
    */
   public static function moveUp() {

      $list = new ContentList(XTools::getParam('menu_id', 0, _INT));
      $list->load();
      $list->moveUp(XTools::getParam('xid', 0, _INT));

   }


   /**
    * Moves all translations of an item down
    */
   public static function moveDown() {

      $list = new ContentList(XTools::getParam('menu_id', 0, _INT));
      $list->load();
      $list->moveDown(XTools::getParam('xid', 0, _INT));

   }


   /**
    * Toggles home status of all translations of an item
    */
   public static function toggleHome() {
      global $xDb;

      // Database query (reset home)
      $query = 'UPDATE #__menunodes ' .
               'SET home = 0        ';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Set new home
      $item = new TranslationList();
      $item->load(XTools::getParam('xid', 0, _INT));
      $item->toggleHome();

   }


   /**
    * Toggles mobile status of all translations of an item
    */
   public static function toggleMobile() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleMobile();

   }


   /**
    * Toggles visibility in sitemap of all translations of an item
    */
   public static function toggleSitemap() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleSitemap();

   }


   /**
    * Toggles publication status of an item
    */
   public static function toggleStatus() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleStatus();

   }


   /**
    * Removes translation
    */
   public static function removeTranslation() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));

      $list = new TranslationList();
      $list->load(XTools::getParam('xid', $item->xid, _INT));

      $list->count() ? $item->remove() : $list->remove();

   }

}
?>