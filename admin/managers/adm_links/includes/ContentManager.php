<?php

/**
 * Manager for XirtCMS (SEF) links
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

      $link = new Link();

      $link->set('cid',     XTools::getParam('nx_cid', 0, _INT));
      $link->set('uri_sef', XTools::getParam('nx_uri_sef'));
      $link->set('uri_ori', XTools::getParam('nx_uri_ori'));
      $link->set('iso',     XTools::getParam('nx_language'));
      $link->set('custom',  1);

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

      $link->set('cid',     XTools::getParam('x_cid', 0, _INT));
      $link->set('uri_sef', XTools::getParam('x_uri_sef'));
      $link->set('uri_ori', XTools::getParam('x_uri_ori'));

      // Already exists
      if ($item = $list->getItemByAttribute('uri_sef', $link->uri_sef)) {

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
