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
      $this->_includeArchive();
      $this->_includeOrdering();
      $this->_includeLanguages();
      $this->_includeOrderingColumns();
      $this->_includeVisibilityOptions();

   }


   /**
    * Includes option list for the archive
    *
    * @access protected
    */
   protected function _includeArchive() {
      global $xCom;

      $this->archive = array(
         1 => $xCom->xLang->options['showArchive'],
         0 => $xCom->xLang->options['hideArchive']
      );

   }


   /**
    * Includes option list for ordering items (direction)
    *
    * @access protected
    */
   protected function _includeOrdering() {
      global $xCom;

      $this->ordering = array(
         'ASC'  => $xCom->xLang->options['ascending'],
         'DESC' => $xCom->xLang->options['descending']
      );

   }


   /**
    * Includes option list for ordering items (columns)
    *
    * @access protected
    */
   protected function _includeOrderingColumns() {
      global $xCom;

      $this->columns = array(
         'author'   => $xCom->xLang->options['sortAuthor'],
         'created'  => $xCom->xLang->options['sortDateCreated'],
         'modified' => $xCom->xLang->options['sortDateModified'],
         'title'    => $xCom->xLang->options['sortTitle']
      );

   }


   /**
    * Includes option list for visibility
    *
    * @access protected
    */
   protected function _includeVisibilityOptions() {
      global $xCom;

      $this->visibilities = array(
         -1 => $xCom->xLang->options['useDefault'],
         0  => $xCom->xLang->options['hideItem'],
         1  => $xCom->xLang->options['showItem']
      );

   }


//      $numericList = range(0, 25);

}
?>