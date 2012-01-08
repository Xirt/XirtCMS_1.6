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

      $list = new ContentList();
      $list->load(XTools::getParam('nx_language'));

      // Retrieve parent node
      $parent = XTools::getParam('nx_parent_id', 0, _INT);
      if (!$parent = $list->getItemById($parent)) {
         return false;
      }

      $item = new Translation();
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

         $config = (Object) array();

         $config->css_name      = XTools::getParam('x_css_name');
         $config->amount_full   = XTools::getParam('x_amount_full',    1, _INT);
         $config->amount_title  = XTools::getParam('x_amount_title',  15, _INT);
         $config->show_archive  = XTools::getParam('x_show_archive',   0, _INT);
         $config->order_col     = XTools::getParam('x_order_col',     null);
         $config->order         = XTools::getParam('x_order',         null);
         $config->show_title    = XTools::getParam('x_show_title',    -1, _INT);
         $config->show_author   = XTools::getParam('x_show_author',   -1, _INT);
         $config->show_created  = XTools::getParam('x_show_created',  -1, _INT);
         $config->show_modified = XTools::getParam('x_show_modified', -1, _INT);
         $config->back_icon     = XTools::getParam('x_back_icon',     -1, _INT);
         $config->download_icon = XTools::getParam('x_download_icon', -1, _INT);
         $config->print_icon    = XTools::getParam('x_print_icon',    -1, _INT);
         $config->mail_icon     = XTools::getParam('x_mail_icon',     -1, _INT);

         $item->set('config', $config);
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