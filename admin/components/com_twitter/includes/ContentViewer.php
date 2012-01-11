<?php

/**
 * Class for viewing saved Twitter tweets
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class ContentViewer {

   /**
    * Shows the main screen
    */
   public static function showTemplate() {
      global $xCom;

      // Show template
      $tpl = new Template();
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all content
    */
   public static function showList() {

      $list = new TweetList();
      $list->setStart(XTools::getParam('start', 0, _INT));
      $list->setLimit(XTools::getParam('limit', 999, _INT));
      $list->setOrder(XTools::getParam('order', 'DESC', _STRING));
      $list->setColumn(XTools::getParam('column', 'xid', _STRING));
      $list->load();
      $list->show();

   }


   /**
    * Shows a JSON object with selected item
    *
    * @param $id Integer of item to load (optional)
    */
   public static function showItem($id = 0) {
      global $xCom;

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new Tweet();
      $item->load($id);
      $item->show();

   }

}
?>