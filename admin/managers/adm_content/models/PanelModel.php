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
      $this->_includeOptions();
      $this->_includeLanguages();

   }


   /**
    * Includes option list for content (default, yes & no)
    *
    * @access protected
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