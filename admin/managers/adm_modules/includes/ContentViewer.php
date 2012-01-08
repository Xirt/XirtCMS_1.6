<?php

/**
 * Class for viewing XirtCMS modules
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

      $tpl = new XAdminTemplate('adm_modules');
      $tpl->assign('xMainLang',    $xLang);
      $tpl->assign('xLang',        $xCom->xLang);
      $tpl->assign('rankList',     XUtils::getRankList());
      $tpl->assign('pagesList',    XUtils::getPageList(true, true));
      $tpl->assign('moduleList',   XUtils::getModuleList());
      $tpl->assign('languageList', XUtils::getLanguageList());
      $tpl->assign('positionList', XUtils::getPositionList());
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all items
    */
   public static function showContentList() {

      $list = new ContentList();
      $list->setLimit(XTools::getParam('limit', 999, _INT));
      $list->setStart(XTools::getParam('start', 0, _INT));
      $list->setColumn(XTools::getParam('column', 'xid', _STRING));
      $list->setOrder(XTools::getParam('order', 'DESC', _STRING));
      $list->load(XTools::getParam('iso'));
      $list->show();

   }


   /**
    * Shows a JSON object containing an item (without configuration)
    *
    * @param $id Integer of item to load (optional)
    */
   public static function showItem($id = 0) {

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new Translation();
      $item->load($id);
      $item->set('config', null, true);
      $item->show();

   }


   /**
    * Shows a JSON object containing an item (configuration only)
    *
    * @param $id Integer of item to load (optional)
    */
   public static function showDetails($id = 0) {

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new Translation();
      $item->load($id);
      $item->setConfiguration();

      // Remove obsolete information
      $item->set('ordering', null, true);
      $item->set('position', null, true);
      $item->set('pages', null, true);

      $item->show();

   }

}
?>