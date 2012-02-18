<?php

/**
 * Library to show content for component
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Viewer {

   /**
    * Shows a 'no javascript' warning
    */
   public static function showNoJavaScript() {
      global $xConf, $xCom;

      // Show template
      $tpl = new Template();
      $tpl->assign('xConf', $xConf);
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->display('no-javascript.tpl');

   }

}
?>