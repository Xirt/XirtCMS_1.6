<?php

/**
 * Class for viewing XirtCMS components
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
      global $xCom;

      // Show template
      $tpl = new XAdminTemplate('adm_components');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('rankList', XUtils::getRankList());
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all content
    */
   public static function showList() {

      $list = new ComponentList();
      $list->setStart(XTools::getParam('start', 0, _INT));
      $list->setLimit(XTools::getParam('limit', 999, _INT));
      $list->setOrder(XTools::getParam('order', 'DESC', _STRING));
      $list->setColumn(XTools::getParam('column', 'id', _STRING));
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

      $item = new Component();
      $item->load($id);
      $item->show();

   }

}
?>