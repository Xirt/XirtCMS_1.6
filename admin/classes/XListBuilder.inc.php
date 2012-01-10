<?php

/**
 * Utility class for creating the HTML structure for XLists
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XListBuilder {

   /**
    * Displays a box to switch languages of the XList
    *
    * @param $list The list of languages to show (optional)
    */
   public static function showLanguage($list) {
      global $xLang;

      if (!is_array($list) || !count($list)) {

         $list = array();
         foreach (Xirt::getLanguages() as $iso => $list) {
            $list[$iso] = $list->name;
         }

      }

      // Show template
      $tpl = new XTemplate();
      $tpl->assign('xLang', $xLang);
      $tpl->assign('languageList', $list);
      $tpl->display('templates/xtemplates/languageBox.tpl');

   }

   /**
    * Displays the table in which the XList loads (mandatory)
    *
    * @param $columns The columns of the table
    */
   public static function showTable($columns) {
      global $xCom;

      $tpl = new XTemplate();
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('columns', $columns);
      $tpl->display('templates/xtemplates/xListTable.tpl');

   }

}
?>