<?php

/**
 * Includes the cookie-consent code on a website
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_cookies extends XModule {

   /**
    * Shows the content
    */
   function showNormal() {

      XInclude::plugin('cookies');

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->display('templates/main.tpl');

   }

}
?>