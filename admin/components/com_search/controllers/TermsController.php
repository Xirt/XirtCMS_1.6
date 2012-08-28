<?php

/**
 * Controller for XirtCMS Search Terms
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TermsController extends XController {

   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {
      $this->_model->load(XTools::getParam('iso'));
   }

}
?>