<?php

/**
 * Controller for the panel
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class PanelController extends XController {

   /**
    * @var Tracks status of this controller / model combination
    */
   private $_ready = false;


   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {

      if ($this->_model) {
         $this->_ready = $this->_model->load(XTools::getParam('id', 0, _INT));
      }

   }


   /**
    * Shows the given view on exit
    */
   function __destruct() {

      if (!is_null($this->_view) && $this->_ready) {
         return ($this->_view = new $this->_view($this->_model));
      }

      Xirt::pageNotFound();

   }

}
?>