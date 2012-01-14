<?php

/**
 * Class for viewing XirtCMS languages
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
      global $xCom;

      $tpl = new XAdminTemplate('adm_languages');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->display('main.tpl');

   }


   /**
    * Shows a JSON list of all content
    */
   public static function showList() {

      $list = new LanguageList();
      $list->load();
      $list->show();

   }

}
?>