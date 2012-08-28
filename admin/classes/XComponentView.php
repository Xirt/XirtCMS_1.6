<?php

/**
 * Default View for the components
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
      global $xCom, $xLang;

      $this->_template = new XAdminTemplate($xCom->name);
      $this->_template->assign('xLang', $xCom->xLang);
      $this->_template->assign('xMainLang', $xLang);

   }

}
?>