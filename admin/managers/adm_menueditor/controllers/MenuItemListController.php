<?php

/**
 * Controller for a list of XirtCMS Menu Items (translations)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MenuItemListController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $actions = array(
         'show', 'translate', 'edit', 'editConfiguration', 'editAccess'
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('xid', 1, _INT));
         if (!isset(current($this->_model->toArray())->id)) {
            trigger_error("[Controller] Menu Item not found", E_USER_NOTICE);
         }

      }

   }


   /**
    * Shows the data in the Model
    *
    * @access protected
    */
   public function show() {
   }


   /**
    * Translates the data in the Model
    *
    * @access protected
    */
   protected function translate() {
      global $xUser;

      // Create from best translation
      $iso = XTools::getParam('language');
      foreach ($this->_model->toArray() as $candidate) {

         if ($candidate->language != $iso) {

            $item = new MenuItemModel();
            $item->load($candidate->id);

            $item->set('id', null,  true);
            $item->set('published', 0);
            $item->set('language',  $iso);
            $item->set('name',      $item->name . '*');
            $item->add();

         }

      }

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {
      global $xCom, $xDb, $xConf;

      // No action should be taken
      $parent = XTools::getParam('x_parent_id', 0, _INT);
      if (!$this->_model->count() || $this->_model->get('parent_id') == $parent) {
         return false;
      }

      $list = new MenuItemsModel();
      $list->load($xConf->language, $this->_model->get('menu_id'));

      // Retrieve new parent
      $parent = $parent ? $list->getItemById($parent) : $list;
      $node = $list->getItemById($this->_model->get('xid'));

      // Never allow recursion of items (!!!)
      if (!$parent || !$node || $node->getItemById($parent->xid)) {
         return !print($xCom->xLang->messages['invalidParent']);
      }

      // Database query (update old level)
      $query = 'UPDATE #__menunodes          ' .
               'SET ordering = ordering - 1  ' .
               'WHERE parent_id = :parent_id ' .
               '  AND ordering > :ordering   ';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $node->parent_id, PDO::PARAM_INT);
      $stmt->bindParam(':ordering', $node->ordering, PDO::PARAM_INT);
      $stmt->execute();

      // Database query (set new parent)
      $query = 'UPDATE #__menunodes           ' .
               'SET parent_id = :parent_id,   ' .
               '    level     = :level + 1,   ' .
               '    ordering  = :ordering + 1 ' .
               'WHERE xid = :xid              ';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $parent->xid, PDO::PARAM_INT);
      $stmt->bindValue(':ordering', $parent->getMaxOrdering(), PDO::PARAM_INT);
      $stmt->bindParam(':level', $parent->level, PDO::PARAM_INT);
      $stmt->bindParam(':xid', $this->_model->get('xid'), PDO::PARAM_INT);
      $stmt->execute();

   }


   /**
    * Modifies the configuration data in the Model
    *
    * @access protected
    */
   protected function editConfiguration() {

      if (XTools::getParam('affect_all')) {

         $this->_model->set('css_name',  XTools::getParam('x_css_name'));
         $this->_model->set('image',     XTools::getParam('x_image'));
         $this->_model->set('link_type', XTools::getParam('x_link_type'));
         $this->_model->set('link',      XTools::getParam('x_link'));
         $this->_model->save();

      }

   }


   /**
    * Modifies the access data in the Model
    *
    * @access protected
    */
   protected function editAccess() {

      if (XTools::getParam('affect_all')) {

         $this->_model->set('access_min', XTools::getParam('access_min', 0, _INT));
         $this->_model->set('access_max', XTools::getParam('access_max', 0, _INT));
         $this->_model->save();

      }

   }

}
?>