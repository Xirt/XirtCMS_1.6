<?php

/**
 * Controller for XirtCMS Content
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentController extends XController {

   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $actions = array(
         'show', 'showDetails', 'edit', 'editConfiguration', 'editAccess',
         'toggleMobile', 'toggleStatus', 'delete'
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam('id', 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Content not found", E_USER_NOTICE);
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

      $this->_model->set('config', '', true);

   }


   /**
    * Shows the data in the Model
    *
    * @access protected
    */
   public function showDetails() {

      $this->_model->set('content', '', true);
      $this->_model->set('meta_title', '', true);
      $this->_model->set('meta_keywords', '', true);
      $this->_model->set('meta_description', '', true);

   }


   /**
    * Adds the data in the Model
    *
    * @access protected
    */
   protected function add() {
      global $xUser;

      $list = new ContentsModel();

      $this->_model->set('author_id',   $xUser->id);
      $this->_model->set('author_name', $xUser->username);
      $this->_model->set('xid',         $list->getMaximum() + 1);
      $this->_model->set('title',       XTools::getParam('nx_title'));
      $this->_model->set('category',    XTools::getParam('nx_category'));
      $this->_model->set('language',    XTools::getParam('nx_language'));
      $this->_model->set('created',     date('c'));

      $this->_model->add();

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {
      global $xUser;

      $this->_model->set('modified',         date('c'));
      $this->_model->set('modifier_id',      $xUser->id);
      $this->_model->set('modifier_name',    $xUser->username);
      $this->_model->set('title',            XTools::getParam('x_title'));
      $this->_model->set('content',          XTools::getParam('x_content'));
      $this->_model->set('meta_title',       XTools::getParam('x_meta_title'));
      $this->_model->set('meta_keywords',    XTools::getParam('x_meta_keywords'));
      $this->_model->set('meta_description', XTools::getParam('x_meta_description'));
      $this->_model->save();

   }


   /**
    * Modifies the configuration data in the Model
    *
    * @access protected
    */
   protected function editConfiguration() {

      if (!XTools::getParam('affect_all')) {

         $config                = (Object) array();
         $config->css_name      = XTools::getParam('x_css_name');
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

      if (!XTools::getParam('affect_all')) {

         $this->_model->set('access_min', XTools::getParam('access_min', 0, _INT));
         $this->_model->set('access_max', XTools::getParam('access_max', 0, _INT));
         $this->_model->save();

      }

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


   /**
    * Deletes the data in the Model
    *
    * @access protected
    */
   protected function delete() {
      $this->_model->delete();
   }

}
?>