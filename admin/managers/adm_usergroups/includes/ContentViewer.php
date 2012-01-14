<?php

/**
 * Class for viewing XirtCMS usergroups
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentViewer {

   /**
    * Shows the main screen
    */
   public static function showTemplate() {
      global $xCom, $xLang;

      $rankList = range(0, 100);
      unset($rankList[0]);

      $languageList = array();
      foreach (Xirt::getLanguages() as $iso => $language) {
         $languageList[$iso] = $language->name;
      }

      // Show template
      $tpl = new XAdminTemplate('adm_usergroups');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('xMainLang', $xLang);
      $tpl->assign('rankList', $rankList);
      $tpl->assign('languageList', $languageList);
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all items
    */
   public static function showContentList() {
      global $xConf;

      $list = new ContentList();
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

      $item = new Translation();
      $item->load($id);
      $item->show();

   }


   /**
    * Shows a JSON object containing an item
    *
    * @param $id Integer of item to load (optional)
    */
   public static function showDetails($id = 0) {

      self::showItem($id);

   }

}
?>