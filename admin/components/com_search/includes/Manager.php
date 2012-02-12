<?php

/**
 * Manager for XirtCMS search terms
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Manager {

   /**
    * Adds item
    */
   public static function addItem() {

      $list = new TermList();
      $list->load(XTools::getParam('nx_language'));

      $link = new Term();
      $link->set('impressions', XTools::getParam('nx_impressions', 0, _INT));
      $link->set('term',        XTools::getParam('nx_term'));
      $link->set('uri',         XTools::getParam('nx_uri'));
      $link->set('language',    XTools::getParam('nx_language'));
      $list->add($link);

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xCom;

      $link = new Term();
      $link->load(XTools::getParam('id', 0, _INT));
      $link->set('impressions', XTools::getParam('x_impressions', 0, _INT));
      $link->set('term',        XTools::getParam('x_term'));
      $link->set('uri',         XTools::getParam('x_uri'));
      $link->save();
   }


   /**
    * Removes item
    */
   public static function removeItem() {

      $link = new Term();
      $link->load(XTools::getParam('id', 0, _INT));
      $link->remove();

   }

}
?>