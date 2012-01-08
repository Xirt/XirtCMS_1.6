<?php

/**
 * Class for viewing XirtCMS templates
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

      $tpl = new XAdminTemplate('adm_templates');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('xMainLang', $xLang);
      $tpl->assign('pagesList', XUtils::getPageList(true, false));
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all content
    */
   public static function showList() {

      $list = new TemplateList();
      $list->load();
      $list->show();

   }


   /**
    * Shows a JSON object containing details about an item
    *
    * @param $id Integer of item to load (optional)
    */
   public static function showItem($id = 0) {

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new Template();
      $item->load($id);
      $item->show();

   }

}
?>
