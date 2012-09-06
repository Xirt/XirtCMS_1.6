<?php

/**
 * Default Model for components
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XComponentModel extends XModel {

   /**
    * Includes all ranks available to the user
    *
    * @access protected
    * @return boolean true
    */
   protected function _includeRanks() {
      global $xUser;

      $list = array();
      foreach (Xirt::getRanks() as $rank) {

         if ($rank->rank <= $xUser->rank) {
            $list[$rank->rank] = $rank->name;
         }

      }

      return ($this->ranks = $list);
   }


   /**
    * Includes option list for content module types
    *
    * @access protected
    */
   protected function _includeModules() {
      $this->modules = XUtils::getModuleList();
   }


   /**
    * Includes option list for all content positions in the templates
    *
    * @access protected
    */
   protected function _includePositions() {
      $this->positions = XUtils::getPositionList();
   }


   /**
    * Includes all languages available to the user
    *
    * @access protected
    * @return boolean true
    */
   protected function _includeLanguages() {

      $list = array();
      foreach (Xirt::getLanguages() as $iso => $language) {
         $list[$iso] = $language->name;
      }

      return ($this->languages = $list);
   }


   /**
    * Includes all pages available to the user
    *
    * @access protected
    * @param $allPages Toggles showing the option 'all pages'
    * @param $unassigned Toggles showing the option 'unassigned'
    * @return boolean true
    */
   protected function _includePages($allPages = 0, $unassigned = 0) {
      return ($this->pages = XUtils::getPageList($allPages, $unassigned));
   }

}
?>