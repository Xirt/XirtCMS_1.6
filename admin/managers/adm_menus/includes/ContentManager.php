<?php

/**
 * Manager for XirtCMS menus
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class ContentManager {

   /**
    * Adds item
    */
   public static function addItem() {

      $list = new ContentList();
      $item = new Translation();

      $item->set('xid',      $list->getMaximum('xid') + 1);
      $item->set('title',    XTools::getParam('nx_title'));
      $item->set('language', XTools::getParam('nx_language'));

      $list->add($item);
   }


   /**
    * Adds translation
    */
   public static function addTranslation() {
      global $xCom;

      $list = new TranslationList();
      $list->load(XTools::getParam('xid', 0, _INT));

      // Create from best translation
      $iso = XTools::getParam('language');
      foreach ($list->toArray() as $candidate) {

         if ($candidate->language != $iso) {

            $item = new Translation();
            $item->load($candidate->id);

            $item->set('id', null, true);
            $item->set('language', $iso);
            $item->set('title', $item->title . '*');

            return $list->add($item);
         }

      }

   }


   /**
    * Edits item
    */
   public static function editItem() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->set('title', XTools::getParam('x_title'));
      $item->save();

   }


   /**
    * Moves all translations of an item up
    */
   public static function moveUp() {

      $list = new ContentList();
      $list->load();
      $list->moveUp(XTools::getParam('xid', 0, _INT));

   }


   /**
    * Moves all translations of an item down
    */
   public static function moveDown() {

      $list = new ContentList();
      $list->load();
      $list->moveDown(XTools::getParam('xid', 0, _INT));

   }


   /**
    * Toggles sitemap status of all translations of an item
    */
   public static function toggleSitemap() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleSitemap();

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
    * Removes translation
    */
   public static function removeTranslation() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->remove();

   }

}
?>