<?php

/**
 * Class for viewing XirtCMS static content
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

      $optionList = array(
         -1 => $xCom->xLang->options['useDefault'],
          0 => $xCom->xLang->options['hideItem'],
          1 => $xCom->xLang->options['showItem']
      );

      // Show template
      $tpl = new XAdminTemplate('adm_content');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('xMainLang', $xLang);
      $tpl->assign('rankList', XUtils::getRankList());
      $tpl->assign('languageList', XUtils::getLanguageList());
      $tpl->assign('optionList', $optionList);
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all items
    */
   public static function showContentList() {

      $list = new ContentList();
      $list->setStart(XTools::getParam('start', 0, _INT));
      $list->setLimit(XTools::getParam('limit', 999, _INT));
      $list->setOrder(XTools::getParam('order', 'DESC', _STRING));
      $list->setColumn(XTools::getParam('column', 'xid', _STRING));
      $list->load(XTools::getParam('iso'));
      $list->show();

   }


   /**
    * Shows a JSON list of all content categories
    */
   public static function showCategoryList() {

      $list = new XCategoryList();
      $list->load();
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
    * @param id Integer of item to load (optional)
    */
   public static function showDetails($id = 0) {

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new Translation();
      $item->load($id);

      // Remove obsolete information
      $item->set('meta_description', null, true);
      $item->set('meta_keywords', null, true);
      $item->set('content', null, true);

      $item->show();

   }

}
?>