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
    * @var The defaul template file to load
    * @access protected
    */
   protected $_file = 'main.tpl';


   /**
    * Sets a new template file to load
    *
    * @param $file The file to load
    */
   function setFile($file) {
      $this->_file = $file;
   }


   /**
    * Shows the model on destruction
    */
   function __destruct() {

      if (isset($this->_template)) {
         $this->_template->display($this->_file);
      }

   }

}
?>