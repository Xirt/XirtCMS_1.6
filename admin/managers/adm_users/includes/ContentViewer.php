<?php

/**
 * Class for viewing XirtCMS users
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
      global $xCom, $xUser;

      $rankList = array();
      foreach (Xirt::getRanks() as $rank) {

         if ($rank->rank <= $xUser->rank) {
            $rankList[$rank->rank] = $rank->name;
         }

      }

      // Show template
      $tpl = new XAdminTemplate('adm_users');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('rankList', $rankList);
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all content
    */
   public static function showList() {

      $list = new UserList();
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
      global $xCom, $xUser;

      if (!isset($id) || !$id = intval($id)) {
         $id = XTools::getParam('id', 0, _INT);
      }

      $item = new User();
      $item->load($id);

      if ($item->rank > $xUser->rank) {

         header('Content-type: application/x-json');
         die(json_encode($xCom->xLang->messages['highRank']));

      }

      $item->show();

   }

}
?>
