<?php

/**
 * Controller for XirtCMS Menus
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MenusController extends XController {

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
         $this->_model->load(XTools::getParam('iso'));
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

      // Previous item (to be switched)
      foreach (array_reverse($this->_model->toArray()) as $previous) {

         if ($previous->ordering < $item->ordering) {
            break;
         }

      }

      $list = new MenuListModel();
      $list->load($item->xid);
      $list->set('ordering', $previous->ordering);
      $list->save();

      $list = new MenuListModel();
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
      foreach ($this->_model->toArray() as $next) {

         if ($next->ordering > $item->ordering) {
            break;
         }

      }

      $list = new MenuListModel();
      $list->load($item->xid);
      $list->set('ordering', $next->ordering);
      $list->save();

      $list = new MenuListModel();
      $list->load($next->xid);
      $list->set('ordering', $item->ordering);
      $list->save();

   }

}
?>