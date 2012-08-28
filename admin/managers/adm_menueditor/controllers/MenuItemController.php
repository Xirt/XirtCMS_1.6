<?php

/**
 * Controller for XirtCMS Menu Items
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MenuItemController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $actions = array(
         'show', 'showDetails', 'edit', 'editAccess', 'editConfiguration',
         'toggleHome', 'toggleSitemap', 'toggleMobile', 'toggleStatus', 'delete'
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('id', 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Menu Item not found", E_USER_NOTICE);
            exit;

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
    * Adds the data in the Model
    *
    * @access protected
    */
   protected function add() {

      // Variables
      $menu = XTools::getParam('menu_id', 0, _INT);
      $parent = XTools::getParam('nx_parent_id', 0, _INT);

      // Containing menu
      $list = new MenuItemsModel();
      $list->load(XTools::getParam('nx_language'), $menu);

      // Retrieve parent node
      if (!$parent = $list->getItemById($parent)) {
         return false;
      }

      $this->_model->set('menu_id',   $menu);
      $this->_model->set('xid',       $list->getMaximum('xid') + 1);            // FIXME: Kan veel hoger zijn; andere menu's!!!!
      $this->_model->set('ordering',  $parent->getMaxOrdering() + 1);
      $this->_model->set('parent_id', $parent->xid);
      $this->_model->set('level',     $parent->level + 1);
      $this->_model->set('name',      XTools::getParam('nx_name'));
      $this->_model->set('language',  XTools::getParam('nx_language'));

      $this->_model->add();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {

      $this->_model->set('name', XTools::getParam('x_name'));
      $this->_model->save();

   }


   /**
    * Modifies the configuration data in the Model
    *
    * @access protected
    */
   protected function editConfiguration() {

      if (!XTools::getParam('affect_all')) {

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

      if (!XTools::getParam('affect_all')) {

         $this->_model->set('access_min', XTools::getParam('access_min', 0, _INT));
         $this->_model->set('access_max', XTools::getParam('access_max', 0, _INT));
         $this->_model->save();

      }

   }


   /**
    * Toggles the sitemap status for the Model
    *
    * @access protected
    */
   protected function toggleSitemap() {

      $value = !intval($this->_model->sitemap);
      $this->_model->set('sitemap', $value);
      $this->_model->save();

   }


   /**
    * Toggles the mobile status for the Model
    *
    * @access protected
    */
   protected function toggleMobile() {

      $value = !intval($this->_model->mobile);
      $this->_model->set('mobile', $value);
      $this->_model->save();

   }


   /**
    * Toggles the publication status for the Model
    *
    * @access protected
    */
   protected function toggleStatus() {

      $value = !intval($this->_model->published);
      $this->_model->set('published', $value);
      $this->_model->save();

   }

}
?>