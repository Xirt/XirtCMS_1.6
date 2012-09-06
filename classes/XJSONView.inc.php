<?php

/**
 * Default View for generating JSON objects
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XJSONView {

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

      header('Content-type: application/x-json');
      print(json_encode($this->_model));

   }

}
?>