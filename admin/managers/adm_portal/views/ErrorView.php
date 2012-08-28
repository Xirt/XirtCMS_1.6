<?php

/**
 * View for the management panel
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ErrorView extends XView {


   /**
    * Shows the model on destruction
    */
   function __destruct() {

      foreach ($this->_model->entries as $entry) {
         print($entry . "<br />");
      }

   }

}
?>

