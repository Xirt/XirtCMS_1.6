<?php

/**
 * Extended version of XNode to add extra menu functionality
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        XNode
 */
class XMenuNode extends XNode {

   /**
    * @var XMenuNodes are by default inactive in the menu
    */
   var $active = false;


   /**
    * Set this item (and parent) as active items
    */
   public function setActive() {

      if (!empty($this->active)) {
         return true;
      }

      $this->active = true;
      $this->parent->setActive();

   }


   /**
    * Search depth-first for MenuItem for the given link and activate it
    *
    * @param $link The link (of the active item) to search for
    */
   public function setActiveByLink($link) {

      if (isset($this->link) && $this->link == $link) {
         $this->setActive();
      }

      foreach ($this->children as $child) {
         $child->setActiveByLink($link);
      }

   }

}
?>