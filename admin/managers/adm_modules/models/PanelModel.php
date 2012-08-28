<?php

/**
 * Model for the management panel
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class PanelModel extends XComponentModel {

   /**
    * Method to load data
    */
   public function load() {

      $this->_includeRanks();
      $this->_includeModules();
      //$this->_includeOptions();
      $this->_includePositions();
      $this->_includeLanguages();
      $this->_includePages(true, true);

   }


   /**
    * Includes option list for content (default, yes & no)
    *
    * @access private
    */
   private function _includeOptions() {
      global $xCom;

      $this->options = array(
         -1 => $xCom->xLang->options['useDefault'],
          0 => $xCom->xLang->options['hideItem'],
          1 => $xCom->xLang->options['showItem']
      );

   }

}
?>