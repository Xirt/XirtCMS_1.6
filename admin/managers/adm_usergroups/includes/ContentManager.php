<?php

/**
 * Manager for XirtCMS usergroups
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
      global $xCom;

      $list = new ContentList();
      $list->load();

      $rank = XTools::getParam('nx_rank', 0, _INT);
      if ($list->getItemByAttribute('rank', $rank)) {
         die($xCom->xLang->messages['rankExists']);
      }

      $item = new Translation();
      $item->set('rank',     $rank);
      $item->set('name',     XTools::getParam('nx_name'));
      $item->set('language', XTools::getParam('nx_language'));
      $list->add($item);

   }


   /**
    * Adds translation
    */
   public static function addTranslation() {
      global $xDb, $xCom;

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
            $item->set('name', $item->name . '*');

            $list->add($item);

         }

      }

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xCom, $xConf;

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));

      $list = new ContentList();
      $list->load($xConf->language);

      $rank = XTools::getParam('x_rank', 0, _INT);
      if ($match = $list->getItemByAttribute('rank', $rank)) {

         if ($match->rank != $item->rank) {
            die($xCom->xLang->messages['rankExists']);
         }

      }

      // Save current translation
      $item->set('name', XTools::getParam('x_name'));
      $item->save();

      // Save all translations
      $list = new TranslationList();
      $list->load($item->rank);

      foreach ($list->getList() as $item) {

         $item->set('rank', $rank);
         $item->save();

      }

   }


   /**
    * Removes translation
    */
   public static function removeTranslation() {
      global $xCom;

      $item = new Translation();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->remove();

      $list = new TranslationList();
      if ($list->load($item->rank) && !$list->count()) {
         die($xCom->xLang->messages['rankRemoved']);
      }

   }

}

?>
