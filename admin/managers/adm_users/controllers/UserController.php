<?php

/**
 * Controller for User
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UserController extends XController {

   /**
    * @var An alias for the Model for this Controller
    *
    * @access protected
    */
   protected $_user = null;


   /**
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $this->_model = new $this->_model;

      if (in_array($this->_action, array('show', 'edit', 'reset', 'delete'))) {

         // Load existing data
         $this->_model->load(XTools::getParam('id', 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] User not found", E_USER_NOTICE);
            exit;

         }

      }

      $this->_user = $this->_model;

   }


   /**
    * Shows the data in the Model
    *
    * @access protected
    */
   public function show() {
      global $xUser;

      if ($this->_user->rank > $xUser->rank) {
         die($xCom->xLang->messages['highRank']);                               // FIXME: This might be bugged in MooTools (expects JSON)
      }

   }


   /**
    * Adds the data in the Model
    *
    * @access protected
    */
   protected function add() {
      global $xCom, $xConf, $xUser;

      $salt     = $this->_generateSalt();
      $password = XTools::generatePassword();

      $this->_user->set('salt',     $salt);
      $this->_user->set('rank',     XTools::getParam('nx_rank', 0, _INT));
      $this->_user->set('name',     XTools::getParam('nx_name'));
      $this->_user->set('mail',     XTools::getParam('nx_mail'));
      $this->_user->set('editor',   XTools::getParam('nx_editor', 0, _INT));
      $this->_user->set('username', XTools::getParam('nx_username'));
      $this->_user->set('password', XAuthentication::hash($password, $salt));

      // Validation: rank insufficient
      if ($xUser->rank < $this->_user->rank) {
         die($xCom->xLang->messages['noHighRankCreate']);
      }

      $list = new UsersModel();
      $list->load();

      // Validation: already exists (username)
      if ($list->getItemByAttribute('username', $this->_user->username)) {
         die($xCom->xLang->messages['nameExists']);
      }

      // Validation: already exists (e-mail address)
      if ($list->getItemByAttribute('mail', $this->_user->mail)) {
         die($xCom->xLang->messages['mailExists']);
      }

      if ($this->_user->add()) {

         // Notify user
         $mail = new CreationNotification($this->_user, $password);
         $mail->send();

      }

   }


   /**
    * Modifies the data in the Model
    *
    * @access protected
    */
   protected function edit() {
      global $xCom, $xUser;

      $this->_user->set('mail',    XTools::getParam('x_mail'));
      $this->_user->set('rank',    XTools::getParam('x_rank', 0, _INT));
      $this->_user->set('name',    XTools::getParam('x_name'));
      $this->_user->set('yubikey', XTools::getParam('x_yubikey'));
      $this->_user->set('editor',  XTools::getParam('x_editor', 0, _INT));

      $list = new UsersModel();
      $list->load();

      // Validation: already exists (e-mail address)
      if ($match = $list->getItemByAttribute('mail', $this->_user->mail)) {

         if ($match->id != $this->_user->id) {
            die($xCom->xLang->messages['mailExists']);
         }

      }

      // Validation: rank insufficient
      if (intval($this->_user->id) !== 1 && $xUser->rank < $this->_user->rank) {
         die($xCom->xLang->messages['noHighRankEdit']);
      }

      $this->_user->save();

   }


   /**
    * Modifies the data in the Model (resets password)
    *
    * @access protected
    */
   protected function reset() {
      global $xCom, $xConf;

      $salt     = $this->_user->salt;
      $password = XTools::getParam('x_password');

      if (!XValidate::isPassword($password)) {
         $password = XTools::generatePassword();
      }

      // Reset password
      $this->_user->set('password', XAuthentication::hash($password, $salt));
      $this->_user->save();

      // Notify user
      $mail = new ResetNotification($this->_user, $password);
      $mail->send();

      // Notification text
      die($xCom->xLang->messages['resetPassword']);

   }


   /**
    * Deletes the data in the Model
    *
    * @access protected
    */
   protected function delete() {
      global $xCom, $xUser;

      if (intval($this->_user->id) === 1) {
         die($xCom->xLang->messages['noRemoveAdmin']);
      }

      if ($xUser->id == $this->_user->id) {
         die($xCom->xLang->messages['noRemoveSelf']);
      }

      if ($xUser->rank < $this->_user->rank) {
         die($xCom->xLang->messages['noHighRankEdit']);
      }

      $this->_user->delete();
   }


   /**
    * Returns a random string for salting
    *
    * @access private
    * @return String The generated random salt
    */
   private function _generateSalt() {
      return substr(md5(uniqid(rand(), true)), 0, 21);
   }

}
?>