<?php

/**
 * Default View for XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XView {

   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {

      $this->_model = $model;
      $this->_init();

   }


   /**
    * Method executed on initialization (overwritable)
    *
    * @access protected
    */
   protected function _init() {
   }


   /**
    * Shows the model on destruction
    */
   function __destruct() {
   }

}
?>