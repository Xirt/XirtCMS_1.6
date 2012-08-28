<?php

/**
 * Class to notify a user of a password change
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ResetNotification {

   /**
    * @var The location of the template
    */
   const TEMPLATE = 'mails/mail-reset.tpl';

   /**
    * @var The UserModel for to use
	 *
	 * @access private
    */
   private $_user = null;


   /**
    * @var The subject of the notification
	 *
	 * @access private
    */
   private $_subject = null;


   /**
    * @var The body content of the notification
	 *
	 * @access private
    */
   private $_body = null;


   /**
    * Prepares the notification with the given data
    *
    * @param Object $user The UserModel to use
    * @param String $password The new password
    */
   function __construct($user, $password) {
      global $xCom, $xConf;

      $xLang = (object) $xCom->xLang->mail;

      // Generate notification
      $body = new XAdminTemplate($xCom->name);
      $body->assign('password', $password);
      $body->assign('xUser',    $this->_user);
      $body->assign('xConf',    $xConf);
      $body->assign('xLang',    $xLang);

      // Save notification
      $this->_user    = $user;
      $this->_subject = $xLang->subject;
      $this->_body    = $body->fetch(self::TEMPLATE);

   }


   /**
    * Sends the e-mail
    */
   function send() {

      $mail = new XMail($this->_user->mail, $this->_subject, $this->_body);
      $mail->setType('html');
      $mail->send();

   }

}
?>