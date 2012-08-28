<?php

/**
 * Controller for Templates
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TemplatesController extends XController {

   /**
    * Unsets active status for all templates
    *
    * @access protected
    */
   protected function unset_active() {

      $this->_model->load();
      $this->_model->set('active', 0);
      $this->_model->save();

   }

}
?>