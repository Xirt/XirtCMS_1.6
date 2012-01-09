<?php

/**
 * Show a simple search screen
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_search extends XModule {

   /**
    * Handles any normal requests
    */
   public function showNormal() {

      $template = $this->xConf->style ? 'template_right' : 'template_left';

      // Show template
      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('xLang', $this->xLang);
      $tpl->display('templates/' . $template . '.tpl');

   }

}
?>