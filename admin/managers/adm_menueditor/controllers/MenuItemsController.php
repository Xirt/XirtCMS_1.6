<?php

/**
 * Controller for XirtCMS Menu Items
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MenuItemsController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $actions = array(
         'show', 'moveUp', 'moveDown'
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('iso'), XTools::getParam('menu_id'));
         if (!isset(current($this->_model->toArray())->id)) {
            trigger_error("[Controller] Menu not found", E_USER_NOTICE);
         }

      }

   }


   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {
   }


   /**
    * Move item up the list of the Model
    *
    * @access protected
    */
   protected function moveUp() {

      // Current item
      $xId = XTools::getParam('xid', 0, _INT);
      if (!$item = $this->_model->getItemByAttribute('xid', $xId)) {
         return false;
      }

      // Previous item with same parent (to be switched)
      foreach (array_reverse($item->parent->children) as $previous) {

         if ($previous->ordering < $item->ordering) {
            break;
         }

      }

      $list = new MenuItemListModel();
      $list->load($item->xid);
      $list->set('ordering', $previous->ordering);
      $list->save();

      $list = new MenuItemListModel();
      $list->load($previous->xid);
      $list->set('ordering', $item->ordering);
      $list->save();

   }


   /**
    * Move item down the list of the Model
    *
    * @access protected
    */
   public function moveDown() {

      // Current Item
      $xId = XTools::getParam('xid', 0, _INT);
      if (!$item = $this->_model->getItemByAttribute('xid', $xId)) {
         return false;
      }

      // Next item (to be switched)
      foreach ($item->parent->children as $next) {

         if ($next->ordering > $item->ordering) {
            break;
         }

      }

      $list = new MenuItemListModel();
      $list->load($item->xid);
      $list->set('ordering', $next->ordering);
      $list->save();

      $list = new MenuItemListModel();
      $list->load($next->xid);
      $list->set('ordering', $item->ordering);
      $list->save();

   }


   /**
    * Toggles the home status for the Model
    *
    * @access protected
    */
   protected static function toggleHome() {
      global $xDb;

      // Reset home
      $query = 'UPDATE #__menunodes SET home = 0';
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Set new home
      $item = new MenuItemListModel();
      $item->load(XTools::getParam('xid', 0, _INT));
      $item->set('home', true);
      $item->save();

   }


   /**
    * Deletes data in the Model
    *
    * @access protected
    */
   protected static function delete() {                                         // Menu ID moet meegegeven worden om hier te komen
                                                                                // Gebruik huidige Model voor $list->delete()?
      $item = new MenuItem();
      $item->load(XTools::getParam('id', 0, _INT));

      $list = new MenuItemsList();
      $list->load(XTools::getParam('xid', $item->xid, _INT));

      $list->count() ? $item->delete() : $list->delete();

   }

}
?>