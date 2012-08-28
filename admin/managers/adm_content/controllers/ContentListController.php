<?php

/**
 * Controller for a list of XirtCMS Content (translations)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentListController extends XController {

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
            trigger_error("[Controller] Content not found", E_USER_NOTICE);
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

            $item = new ContentModel();
            $item->load($candidate->id);

            $item->set('id',          null, true);
            $item->set('published',   0);
            $item->set('content',     '');
            $item->set('language',    $iso);
            $item->set('created',     date('c'));
            $item->set('author_id',   $xUser->id);
            $item->set('author_name', $xUser->username);
            $item->set('title',       $item->title . '*');

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

      $this->_model->set('category', XTools::getParam('x_category', 0, _INT));
      $this->_model->save();

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

}
?>