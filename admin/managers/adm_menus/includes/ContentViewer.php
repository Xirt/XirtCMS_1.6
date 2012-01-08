<?php

/**
 * Class for viewing XirtCMS menus
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class ContentViewer {

   /**
    * Shows the main screen
    */
   public static function showTemplate() {
      global $xCom, $xLang;

      $languageList = array();
      foreach (Xirt::getLanguages() as $iso => $language) {
         $languageList[$iso] = $language->name;
      }

      // Show template
      $tpl = new XAdminTemplate('adm_menus');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('xMainLang', $xLang);
      $tpl->assign('languageList', $languageList);
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all content
    */
   public static function showContentList() {

      $list = new ContentList();
      $list->load(XTools::getParam('iso'));
      $list->show();

   }


   /**
    * Shows a JSON object with selected item
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

}
?>