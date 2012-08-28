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
    * Method executed on initialization to load Model
    *
    * @access protected
    */
   protected function _init() {

      $email    = XTools::getParam('request_mail');
      $username = XTools::getParam('request_name');

      $this->_user = new $this->_model;
      $this->_user->loadByName($username, $email);

   }


   /**
    * Modifies the data in the Model (resets password)
    *
    * @access protected
    */
   protected function reset() {
      global $xCom, $xConf;

      $salt     = $this->_user->salt;
      $password = XTools::generatePassword();

      // Reset password
      $this->_user->set('password', XAuthentication::hash($password, $salt));
      $this->_user->save();

      // Notify user
      $mail = new ResetNotification($this->_user, $password);
      $mail->send();

      // Notification text
      die(sprintf($xCom->xLang->messages['newPassword'], $this->_user->mail));

   }

}
?>