<?php

/**
 * Default View for generating Smarty template
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XTemplateView extends XView {

   /**
    * Shows the model on destruction
    */
   function __destruct() {

      if (isset($this->_template)) {
         $this->_template->display('main.tpl');
      }

   }

}
?>