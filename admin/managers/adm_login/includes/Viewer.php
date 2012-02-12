<?php

/**
 * Viewer for showing the login form
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Viewer {

   /**
    * Shows the login panel
    */
   public static function showForm() {
      global $xCom, $xConf, $xUser;

      $xConf->hideTemplate();

      if ($xUser->isAuth($xConf->adminLevel)) {
         return header('Location: index.php?content=adm_portal');
      }

      // Show template
      $tpl = new XAdminTemplate('adm_login');
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->display('main.tpl');

   }

}
?>