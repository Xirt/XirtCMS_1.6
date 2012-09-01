<?php

/**
 * Utility class for node moderation
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class NodeUtils {

   /**
    * Removes a node from the dabase (including children)
    *
    * @param $model The MenuItemListModel to remove
    */
   public function remove($model) {
      global $xDb;

      NodeUtils::_removeNode($model->get('xid'));

      // Database query (adjust ordering)
      $query = 'UPDATE #__menunodes          ' .
               'SET ordering = ordering - 1  ' .
               'WHERE parent_id = :parent_id ' .
               'AND ordering > :ordering     ';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $model->get('parent_id'), PDO::PARAM_INT);
      $stmt->bindParam(':ordering', $model->get('ordering'), PDO::PARAM_INT);
      $stmt->execute();

   }


   /**
    * Removes a node from the dabase (including children)
    *
    * @access private
    * @param $xId Integer holding the node ID of the node to remove
    */
   private function _removeNode($xId) {
      global $xDb;

      // Database query (retrieve children)
      $query = 'SELECT xid                   ' .
               'FROM #__menunodes            ' .
               'WHERE parent_id = :parent_id ';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $xId, PDO::PARAM_INT);
      $stmt->execute();

      // Remove children
      while ($node = $stmt->fetchObject()) {
         NodeUtils::_removeNode($node->xid);
      }

      // Database query (remove)
      $query = 'DELETE FROM #__menunodes     ' .
               'WHERE xid = :xid             ';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':xid', $xId, PDO::PARAM_INT);
      $stmt->execute();

   }

}
?>