<?php

/**
 * Controller for a list of XirtCMS Usergroup (translations)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UsergroupListController extends XController {

   /**
    * @var An alias for the Model for this Controller
    *
    * @access protected
    */
   protected $_usergroup = null;


   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;

      if (in_array($this->_action, array('show', 'translate', 'edit'))) {

         // Load existing data
         $this->_model->load(XTools::getParam('xid', 1, _INT));
         if (!isset(current($this->_model->toArray())->rank)) {
            trigger_error("[Controller] Usergroup not found", E_USER_NOTICE);
         }

      }

      $this->_usergroup = $this->_model;

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
      foreach ($this->_usergroup->toArray() as $candidate) {

         if ($candidate->language != $iso) {

            $item = new UsergroupModel();
            $item->load($candidate->id);

            $item->set('id', null, true);
            $item->set('language', $iso);
            $item->set('name', $item->name . '*');

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
      global $xCom;

      $list = new UsergroupsModel();
      $list->load();

      // Validation: already exists (rank)
      $rank = XTools::getParam('x_rank', 0, _INT);
      if ($match = $list->getItemByAttribute('rank', $rank)) {

         if ($rank != $this->_usergroup->rank) {
            die($xCom->xLang->messages['rankExists']);
         }

      }

      // Save all translations
      $this->_usergroup->set('rank', $rank);
      $this->_usergroup->save();

   }

}
?>