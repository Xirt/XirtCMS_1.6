<?php

/**
 * Manager for saved Twitter tweets
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class Manager {


   /**
    * Toggles publication status of an item
    */
   public static function toggleStatus() {

      $item = new Tweet();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->toggleStatus();

   }


   /**
    * Removes a tweet
    */
   public static function removeItem() {
      global $xCom, $xUser;

      $tweet = new Tweet();
      $tweet->load(XTools::getParam('id', 0)); // NOTE: 'id' can exceed MAX_INT
      $tweet->remove();

   }

}
?>