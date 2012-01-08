<?php

/**
 * Manager for XirtCMS components
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class ContentManager {

   /**
    * Edits access
    */
   public static function editAccess() {

      $item = new Component();
      $item->load(XTools::getParam('id', 0, _INT));
      $item->set('access_min', XTools::getParam('access_min', 0, _INT));
      $item->set('access_max', XTools::getParam('access_max', 0, _INT));
      $item->save();

   }

}
?>