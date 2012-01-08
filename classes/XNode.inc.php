<?php

/**
 * Class holding node information for XTree
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        XTree
 */
class XNode {

   /**
    * @var The level of this node in the tree
    */
   var $level = 0;


   /**
    * @var The ID of this node
    */
   var $xid = 0;


   /**
    * @var The ordering of this node in the tree
    */
   var $ordering = 0;


   /**
    * @var List of all children of the this node
    */
   var $children = array();


   /**
    * CONSTRUCTOR
    *
    * @param $data Object containing required data for XNode
    * @throws Exception Thrown if data does not contain required data
    */
   function __construct($data) {

      if (!isset($data->xid)) {
         throw new Exception("XNode: No node ID (xId) found");
      }

      if (!isset($data->parent_id)) {
         throw new Exception("XNode: No parent ID found");
      }

      if (!isset($data->ordering)) {
         throw new Exception("XNode: No ordering found");
      }

      foreach ($data as $attrib => $value) {

         if (is_object($value)) {

            trigger_error("XNode: Unexpected Object ignored", E_USER_WARNING);
            continue;

         }

         $this->$attrib = $value;
      }

   }


   /**
    * Returns amount of children
    *
    * @return int The amount of children found
    */
   public function countChildren() {

      return count($this->children);
   }


   /**
    * Adds a node
    *
    * @access protected
    * @param $node The XNode that should be added
    */
   protected function _add(XNode &$node) {

      $this->children[] = $node;
      $node->level  = $this->level + 1;
      $node->parent = &$this;

   }


   /**
    * Sorts children of XNode by variable 'ordering' using QuickSort
    *
    * @access protected
    * @param $node The node to start sorting at (optional, default root)
    * @param $doDeepScan Toggles deepscan sorting (optional, defaults true)
    */
   protected function sort(XNode $node = null, $doDeepScan = true) {

      $node = $node ? $node : $this;
      $node->children = $this->_qckSort($node->children);

      if ($doDeepScan) {

         foreach ($node->children as $child) {
            $this->sort($child);
         }

      }

   }


   /**
    * Sorts an Array of XNodes by variable 'ordering' using QuickSort
    *
    * @access protected
    * @param $list Array containing XNodes to sort
    * @return Array Sorted list of XNodes
    */
   protected function _qckSort($list) {

      // No sorting required
      if (count($list) < 2) {
         return $list;
      }

      $x = $z = array();
      $y = array_shift($list);

      foreach ($list as $node) {

         if ($node->ordering < $y->ordering) {
            $x[] = $node;
            continue;
         }

         if ($node->ordering > $y->ordering) {
            $z[] = $node;
            continue;
         }

         trigger_error("XNode: Duplicate found: " . $node->id, E_USER_WARNING);

      }

      return array_merge($this->_qckSort($x), array($y), $this->_qckSort($z));
   }


   /**
    * Returns first occurence of XNode by node ID (uses depth-first search)
    *
    * @param $id Integer with the node ID to search for
    * @return found XNode or null on failure
    */
   public function getItemById($id) {

      if ($this->xid == $id) {
         return $this;
      }

      foreach ($this->children as $child) {

         if ($node = $child->getItemById($id)) {
            return $node;
         }

      }

      return null;
   }


   /**
    * Returns the maximum ordering in use
    *
    * @return int Maximum ordering found or 0
    */
   public function getMaxOrdering() {

      if (!isset($this->children) || !count($this->children)) {
          return 0;
      }

      foreach ($this->children as $child) {
         $max = max(isset($max) ? $max : 0, $child->ordering);
      }

      return $max;
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this);
   }


   /**
    * Shows list as JSON Object
    */
   public function show() {

      header('Content-type: application/x-json');
      die($this->encode());

   }


   /**
    * Enables correct cloning of the XNode
    */
   public function __clone() {

      $this->parent = null;

      foreach ($this->children as $key => $child) {

         $this->children = $key ? $this->children : array();
         $this->_add(clone $child);

      }

   }

}
?>