<?php

/**
 * Manager for XirtCMS static content
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
      global $xUser;

      $list = new ContentList();
      $item = new Translation();

      $item->set('xid',         $list->getMaximum('xid') + 1);
      $item->set('author_id',   $xUser->id);
      $item->set('author_name', $xUser->username);
      $item->set('title',       XTools::getParam('nx_title'));
      $item->set('category',    XTools::getParam('nx_category'));
      $item->set('language',    XTools::getParam('nx_language'));
      $item->set('created',     date('Y-m-d H:i:s'));

      $list->add($item);

   }


   /**
    * Adds translation
    */
   public static function addTranslation() {
      global $xCom, $xUser;

      $list = new TranslationList();
      $list->load(XTools::getParam('xid', 0, _INT));

      // Create from best translation
      $iso = XTools::getParam('language');
      foreach ($list->toArray() as $candidate) {

         if ($candidate->language != $iso) {

            $item = new Translation();
            $item->load($candidate->id);

            $item->set('id', null,    true);
            $item->set('published',   0);
            $item->set('content',     '');
            $item->set('language',    $iso);
            $item->set('created',     time());
            $item->set('author_id',   $xUser->id);
            $item->set('author_name', $xUser->username);
            $item->set('title',       $item->title . '*');

            return $list->add($item);
         }

      }

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xUser;

      // Save content
      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->set('modified',         time());
      $item->set('modifier_id',      $xUser->id);
      $item->set('modifier_name',    $xUser->username);
      $item->set('title',            XTools::getParam('x_title'));
      $item->set('content',          XTools::getParam('x_content'));
      $item->set('meta_title',       XTools::getParam('x_meta_title'));
      $item->set('meta_keywords',    XTools::getParam('x_meta_keywords'));
      $item->set('meta_description', XTools::getParam('x_meta_description'));
      $item->save();

      // Save category
      $list = new TranslationList();
      $list->load(intval($item->xid));

      foreach ($list->toArray() as $item) {

         $item->set('category', XTools::getParam('x_category', 0, _INT));
         $item->save();

      }

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
    * Toggles mobile status of all translations of an item
    */
   public static function toggleMobile() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleMobile();

   }


   /**
    * Toggles publication status of all translations of an item
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
      $item->remove();

   }

}
?>