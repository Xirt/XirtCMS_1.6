<?php

/**
 * Default View for the components (frontend)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XComponentView extends XTemplateView {

   /**
    * Method executed on initialization to load template
    *
    * @access protected
    */
   protected function _init() {
      global $xCom, $xConf, $xLang;

      $tpl = sprintf(XTemplate::COMPONENTS, $xConf->baseDir, $xCom->name);

      // Prepare template
      $this->_template = new XTemplate($tpl);
      $this->_template->assign('xLang', $xCom->xLang);
      $this->_template->assign('xMainLang', $xLang);

   }

}
?>