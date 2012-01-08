<?php

/**
* Manager for XirtCMS content categories
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

      $numericList = range(0, 25);

      $visibilityList = array(
         -1 => $xCom->xLang->options['useDefault'],
          0 => $xCom->xLang->options['hideItem'],
          1 => $xCom->xLang->options['showItem']
      );

      $archiveList = array(
         1 => $xCom->xLang->options['showArchive'],
         0 => $xCom->xLang->options['hideArchive'],
      );

      $orderList = array(
         'ASC'  => $xCom->xLang->options['ascending'],
         'DESC' => $xCom->xLang->options['descending'],
      );

      $columnList = array(
         'author'   => $xCom->xLang->options['sortAuthor'],
         'created'  => $xCom->xLang->options['sortDateCreated'],
         'modified' => $xCom->xLang->options['sortDateModified'],
         'title'    => $xCom->xLang->options['sortTitle'],
      );

      // Show template
      $tpl = new XAdminTemplate('adm_categories');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('xMainLang', $xLang);
      $tpl->assign('rankList', XUtils::getRankList());
      $tpl->assign('languageList', XUtils::getLanguageList());
      $tpl->assign('visibilityList', $visibilityList);
      $tpl->assign('numericList', $numericList);
      $tpl->assign('archiveList', $archiveList);
      $tpl->assign('columnList', $columnList);
      $tpl->assign('orderList', $orderList);
      $tpl->display('main.tpl');

   }

   /**
    * Shows a JSON list of all content
    */
   public static function showContentList() {
      global $xConf;

      $list = new ContentList();
      $list->load(XTools::getParam('iso'));
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

      $item = new Translation();
      $item->load($id);
      $item->show();

   }

}
?>