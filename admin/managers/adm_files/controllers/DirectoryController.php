<?php

/**
 * Controller for directory contents
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class DirectoryController extends XController {


   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {

      if ($this->_model) {
         $this->_model->load(XTools::getParam('dir', './', _STRING));
      }

   }

}
?>