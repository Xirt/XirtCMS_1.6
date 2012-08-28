<?php

/**
 * Module to show a simple login screen
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_login extends XModule {

   /**
    * Handles any normal requests
    */
   public function showNormal() {

      $template = !XAuthentication::check() ? 'form-login' : 'form-logout';

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('xLang', $this->xLang);
      $tpl->display('templates/' . $template . '.tpl');

   }

}
?>