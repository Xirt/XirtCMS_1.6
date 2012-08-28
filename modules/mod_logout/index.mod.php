<?php

/**
 * Module to show a simple logout button
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_logout extends XModule {

   /**
    * Handles any normal requests
    */
   public function showNormal() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('xLang', $this->xLang);
      $tpl->display('template.tpl');

   }

}
?>