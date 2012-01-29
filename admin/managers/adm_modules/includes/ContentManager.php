<?php

/**
 * Manager for XirtCMS module instances
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentManager {

   /**
    * @var String with the location of the module files
    */
   const LOCATION = "%s/modules/%s/";


   /**
    * Adds item
    */
   public static function addItem() {
      global $xConf;

      $list = new ContentList();
      $item = new Translation();

      $item->set('xid',      $list->getMaximum() + 1);
      $item->set('type',     XTools::getParam('nx_type'));
      $item->set('name',     XTools::getParam('nx_name'));
      $item->set('language', XTools::getParam('nx_language'));

      $path = sprintf(self::LOCATION, $xConf->baseDir, $item->type);
      $file = new XFile($path, 'index.mod.xml');

      if ($file->readable()) {

         $item->resetConfiguration();
         $list->add($item);

      }

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

            $item->set('id', null, true);
            $item->set('language', $iso);
            $item->set('published', 0);
            $item->set('name', $item->name . '*');

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
      $list = array($item);

      if (XTools::getParam('affect_all')) {

         $list = new TranslationList();
         $list->load(XTools::getParam('xid', 0, _INT));
         $list = $list->toArray();

      }

      $type = current($list)->type;
      $config = XModule::getConfiguration($type);

      foreach ($list as $item) {

         foreach ($config as $name => $details) {

            $value = XTools::getParam('xvar_' . $name);
            $item->config->$name = trim($value);

         }

         $item->set('name', XTools::getParam('x_name'));
         $item->save();

      }

   }


   /**
    * Edits configuration
    */
   public static function editConfiguration() {

      $list = new TranslationList();
      $list->load(XTools::getParam('xid', 0, _INT));

      foreach ($list->toArray() as $item) {

         $item->set('position', XTools::getParam('x_position'));
         $item->set('ordering', XTools::getParam('x_ordering'));
         $item->set('pages', XTools::getParam('x_pages'));
         $item->save();

      }

   }


   /**
    * Edits access
    */
   public static function editAccess() {

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $list = array($item);

      if (XTools::getParam('affect_all')) {

         $list = new TranslationList();
         $list->load(XTools::getParam('xid', 0, _INT));
         $list = $list->toArray();

      }

      foreach ($list as $item) {

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