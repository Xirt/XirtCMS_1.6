<?php

/**
 * Controller for a list of XirtCMS Categories (translations)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class CategoryListController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $actions = array(
         'show', 'translate', 'edit', 'editConfiguration', 'editAccess',
         'delete'
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('xid', 1, _INT));
         if (!isset(current($this->_model->toArray())->id)) {
            trigger_error("[Controller] Category not found", E_USER_NOTICE);
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

      // Create from best translation
      $iso = XTools::getParam('language');
      foreach ($this->_model->toArray() as $candidate) {

         if ($candidate->language != $iso) {

            $item = new CategoryModel();
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

      $list = new CategoriesModel();
      $list->load($xConf->language);

      // Retrieve new parent
      $parent = $parent ? $list->getItemById($parent) : $list;
      $node = $list->getItemById($this->_model->get('xid'));

      // Never allow recursion of items (!!!)
      if (!$parent || !$node || $node->getItemById($parent->xid)) {
         return !print($xCom->xLang->messages['invalidParent']);
      }

      // Database query (update old level)
      $query = 'UPDATE #__content_categories ' .
               'SET ordering = ordering - 1  ' .
               'WHERE parent_id = :parent_id ' .
               '  AND ordering > :ordering   ';

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $node->parent_id, PDO::PARAM_INT);
      $stmt->bindParam(':ordering', $node->ordering, PDO::PARAM_INT);
      $stmt->execute();

      // Database query (set new parent)
      $query = 'UPDATE #__content_categories  ' .
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

         $config                = (Object) array();
         $config->css_name      = XTools::getParam('x_css_name');
         $config->amount_full   = XTools::getParam('x_amount_full',    1, _INT);
         $config->amount_title  = XTools::getParam('x_amount_title',  15, _INT);
         $config->show_archive  = XTools::getParam('x_show_archive',   0, _INT);
         $config->order_col     = XTools::getParam('x_order_col',     null);
         $config->order         = XTools::getParam('x_order',         null);
         $config->show_title    = XTools::getParam('x_show_title',    -1, _INT);
         $config->show_author   = XTools::getParam('x_show_author',   -1, _INT);
         $config->show_created  = XTools::getParam('x_show_created',  -1, _INT);
         $config->show_modified = XTools::getParam('x_show_modified', -1, _INT);
         $config->back_icon     = XTools::getParam('x_back_icon',     -1, _INT);
         $config->download_icon = XTools::getParam('x_download_icon', -1, _INT);
         $config->print_icon    = XTools::getParam('x_print_icon',    -1, _INT);
         $config->mail_icon     = XTools::getParam('x_mail_icon',     -1, _INT);

         $this->_model->set('config', $config);
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


   /**
    * Removes the Model from the database
    *
    * @access protected
    */
   protected function delete() {

      // Remove a translation
      if ($this->_model->count() > 1) {

         $id = XTools::getParam('id', 0, _INT);
         if ($current = $this->_model->getItemByAttribute('id', $id)) {
            return $current->deleteFromDatabase('#__content_categories');
         }

      }

      NodeUtils::remove($this->_model);

   }

}
?>