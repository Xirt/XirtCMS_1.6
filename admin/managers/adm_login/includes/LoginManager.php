<?php

/**
 * Manager for handling authentication (back-end)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LoginManager {

   /**
    * Attempts to authenticate the user
    */
   public static function login() {
      global $xCom;

      $user = XTools::getParam('user_name');
      $pass = XTools::getParam('user_pass');

      if (!XAuthentication::create($user, $pass)) {

         die($xCom->xLang->messages['loginFail']);

      }

   }


   /**
    * Logs out current user
    */
   public static function logout() {

      XAuthentication::destroy();
      header('Location: index.php');

   }


   /**
    * Resets password for the given user
    */
   public static function requestPassword() {
      global $xCom, $xConf, $xDb;

      $password = XTools::generatePassword();
      $email    = XTools::getParam('request_mail');
      $username = XTools::getParam('request_name');
      $content  = (object) $xCom->xLang->mail;

      // Reset password
      $user = new User();
      $user->loadByName($username, $email);
      $user->set('password', XAuthentication::hash($password, $user->salt));
      $user->save();

      // Generate mail content
      $body = new XAdminTemplate('adm_login');
      $body->assign('xUser', $user);
      $body->assign('xConf', $xConf);
      $body->assign('xLang', $content);
      $body->assign('password', $password);
      $body = $body->fetch('mails/mail-reset.tpl');

      // Sent mail
      $mail = new XMail($user->mail, $content->subject, $body);
      $mail->setType('html');
      $mail->send();

      // Notification text
      die(sprintf($xCom->xLang->messages['newPassword'], $user->mail));

   }

}
?>