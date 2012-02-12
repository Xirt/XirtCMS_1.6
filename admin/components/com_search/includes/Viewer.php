<?php

/**
 * Viewer for XirtCMS SEF links
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Viewer {

   /**
    * Shows the main screen
    */
   public static function showTemplate() {
      global $xCom;

      $languageList = array();
      foreach (Xirt::getLanguages() as $iso => $language) {
         $languageList[$iso] = $language->name;
      }

      // Show template
      $tpl = new Template();
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('languageList', $languageList);
      $tpl->display('main.tpl');
   }


   /**
    * Shows a JSON list of all items
    */
   public static function showList() {

      $list = new TermList();
      $list->setStart(XTools::getParam('start', 0, _INT));
      $list->setLimit(XTools::getParam('limit', 999, _INT));
      $list->setOrder(XTools::getParam('order', 'DESC', _STRING));
      $list->setColumn(XTools::getParam('column', 'xid', _STRING));
      $list->load(XTools::getParam('iso'));
      $list->show();

   }


   /**
    * Shows a JSON object with all items
    *
    * @param $id Integer of item to load (optional)
    */
   public static function showItem($id = 0) {

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new Term();
      $item->load($id);
      $item->show();

   }

}
?>