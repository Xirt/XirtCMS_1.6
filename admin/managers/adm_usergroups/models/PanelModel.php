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

      $this->_includeLanguages();
      $this->_includeCustomRanks();

   }


   /**
    * Includes al custom list with all ranks (1 - 100)
    *
    * @access protected
    */
   private function _includeCustomRanks() {

      $this->ranks = range(0, 100);
      unset($this->ranks[0]);

   }

}
?>