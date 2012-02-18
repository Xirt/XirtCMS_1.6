<?php

/**
 * Class that generates/holds a basic tree used in XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package	   XirtCMS
 * @see        XNode
 */
class XTree extends XNode {

   /**
    * @var Overrides level of (extended) XNode
    */
   var $level = 0;


   /**
    * @var Overrides node ID of (extended) XNode
    */
   var $xid  = 0;


   /**
    * @var Holds the tree as an array (used as cache)
    */
   private $_tree = false;


   /**
    * @var Holds true when variable _tree is not up-to-date
    */
   private $_isChanged = false;


   /**
    * CONSTRUCTOR (overrides XNode constructor)
    */
   function __construct() {
   }


   /**
    * Returns menu as an Object
    *
    * @return Object The tree as an Object
    */
   public function getTree() {
      return $this;
   }


   /**
    * Returns tree as an Array
    *
    * @return Array The tree as an Array
    */
   public function toArray() {

      if ($this->_tree && !$this->_isChanged) {
         return $this->_tree;
      }

      $this->_tree = $this->_toArray($this);
      $this->_isChanged = false;

      return $this->_tree;
   }


   /**
    * Generates tree as an Array and returns it
    *
    * @access private
    * @param $node The starting node
    * @return Array The tree as an Array
    */
   private function _toArray($node) {

      $list = array();
      foreach ($node->children as $child) {
         $clone = clone $child;

         $list[] = $clone;
         $list = array_merge($list, $this->_toArray($child));

         // Remove / reset recursion data
         unset($clone->parent);

         $clone->children = null;
      }

      return $list;
   }


   /**
    * Attempts to add a XNode
    *
    * @param node XNode to add tree
    * @return boolean Returns true on success, false on failure
    */
   public function add(&$node) {

      // Add new 'branch' to root
      if (!$node->parent_id) {

         $this->_add($node);
         $this->sort(null, false);
         $this->_isChanged = true;

         return true;
      }

      // Add new 'leaf' to tree
      if ($parentNode = $this->getItemById($node->parent_id)) {

         $parentNode->_add($node);
         $parentNode->sort(null, false);
         $this->_isChanged = true;

         return true;
      }

      return false;
   }


   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns item as a JSON Object
    */
   public function encode() {
      return json_encode($this->_tree);
   }


   /**
    * Shows list as JSON Object
    */
   public function show() {

      header('Content-type: application/x-json');
      die($this->encode());

   }


   /**
    * Enables correct cloning of the XTree
    */
   public function __clone() {

      foreach ($this->children as $key => $child) {

         $this->children = $key ? $this->children : array();
         $this->_add(clone $child);

      }

   }

}
?>