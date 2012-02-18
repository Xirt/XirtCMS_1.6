<?php

/**
 * Manager for XirtCMS (SEF) links
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

      $link = new Link();

      $link->set('cid',         XTools::getParam('nx_cid', 0, _INT));
      $link->set('alternative', XTools::getParam('nx_alternative'));
      $link->set('query',       XTools::getParam('nx_query'));
      $link->set('iso',         XTools::getParam('nx_language'));
      $link->set('custom',      1);

      $list = new LinkList($link->iso);
      $list->load();
      $list->add($link);

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xCom;

      $link  = new Link();
      $link->load(XTools::getParam('id', 0, _INT));

      $list = new LinkList();
      $list->load();

      $link->set('cid',         XTools::getParam('x_cid', 0, _INT));
      $link->set('alternative', XTools::getParam('x_alternative'));
      $link->set('query',       XTools::getParam('x_query'));

      // Already exists
      if ($item = $list->getItemByAttribute('alternative', $link->alternative)) {

         if ($item->id != $link->id) {
            die($xCom->xLang->messages['linkUsed']);
         }

      }

      $link->save();

   }


   /**
    * Removes item
    */
   public static function removeItem() {

      $link = new Link();
      $link->load(XTools::getParam('id', 0, _INT));
      $link->remove();

   }

}
?>