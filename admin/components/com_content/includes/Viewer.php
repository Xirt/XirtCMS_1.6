<?php

/**
 * Viewer for XirtCMS content viewer
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Viewer {

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
      $tpl->assign('xConf', $xCom->xConf);
      $tpl->assign('options', $optionList);
      $tpl->assign('xMainLang', $xLang);
      $tpl->display('main.tpl');

   }

}
?>