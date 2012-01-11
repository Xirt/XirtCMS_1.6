<?php

/**
 * Manager for XirtCMS static content viewer
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ViewManager {

   /**
    * Shows the main screen
    */
   public static function showTemplate() {
      global $xCom, $xLang;

      $optionList = array(
         $xCom->xLang->options['hideItem'],
         $xCom->xLang->options['showItem']
      );

      // Show template
      $tpl = new Template();
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('xMainLang', $xLang);
      $tpl->assign('xConf', $xCom->xConf);
      $tpl->assign('optionList', $optionList);
      $tpl->display('main.tpl');

   }


   /**
    * Edits configuration
    */
   public static function save() {
      global $xCom, $xDb;

      $config = (Object)array();
      $config->css_name      = XTools::getParam('item_css_name');
      $config->show_title    = XTools::getParam('item_show_title', _INT, 0);
      $config->show_author   = XTools::getParam('item_show_author', _INT, 0);
      $config->show_created  = XTools::getParam('item_show_created', _INT, 0);
      $config->show_modified = XTools::getParam('item_show_modified', _INT, 0);
      $config->back_icon     = XTools::getParam('item_back_icon', _INT, 0);
      $config->download_icon = XTools::getParam('item_download_icon', _INT, 0);
      $config->print_icon    = XTools::getParam('item_print_icon', _INT, 0);
      $config->mail_icon     = XTools::getParam('item_mail_icon', _INT, 0);
      $config = XTools::addslashes(json_encode($config));

      $query = "UPDATE #__components
                SET config = '%s'
                WHERE com_name = 'com_content'";
      $xDb->setQuery(sprintf($query, $config));
      $xDb->query();

   }

}
?>