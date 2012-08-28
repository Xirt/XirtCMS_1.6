<?php

/**
 * Controller for the management panel
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ErrorController extends XController {

   /**
    * Removes the model (all errors) and resets (error) notification
    *
    * @access protected
    */
   protected function clear() {

      $this->_model->clear();
      $this->reset();

   }


   /**
    * Resets the (error) notification for the model
    *
    * @access protected
    */
   protected function reset() {
      $this->_model->reset();
   }

}
?>