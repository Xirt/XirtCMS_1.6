<?php

/**
 * Module to show a simple login screen
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_contact extends XModule {

   /**
    * Handles any normal requests
    */
   public function showNormal() {

      Xirt::noScript();

      $location = $_SERVER["REQUEST_URI"];
      $location = stripslashes(htmlspecialchars($location, ENT_QUOTES));

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('xLang', $this->xLang);
      $tpl->assign('location', $location);
      $tpl->display('templates/template.tpl');

   }


   /**
    * Handles any AJAX requests
    */
   public function showAJAX() {

      if (($data = $this->_receive()) && $this->_check($data)) {

         $this->_send($data);
         print($this->xLang->messages['finished']);
         return true;

      }

      print($this->xLang->messages['failure']);

   }


   /**
    * Captures the form data in an object
    *
    * @access private
    * @return Object containing form data or null on failure
    */
   private function _receive() {

      if (!XTools::getParam('x_submit')) {
         return null;
      }

      $data          = (Object)array();
      $data->company = XTools::getParam("x_company");
      $data->title   = XTools::getParam("x_title");
      $data->phone   = XTools::getParam("x_phone");
      $data->name    = XTools::getParam("x_name");
      $data->email   = XTools::getParam("x_email");
      $data->subject = XTools::getParam("x_subject");
      $data->message = XTools::getParam("x_message");

      // Retrieve value for option fields
      if (array_key_exists($data->title, $this->xLang->options['titles'])) {
         $data->title = $this->xLang->options['titles'][$data->title];
      }

      return $data;
   }


   /**
    * Sends the e-mail to the set recipient
    *
    * @access private
    * @param $data Object containing the form data
    * @return boolean True if validated, false otherwhise
    */
   private function _check($data) {

      $valid = true;
      $valid = XValidate::hasLength($data->name, 1, 50)    ? $valid : false;
      $valid = XValidate::isPhone($data->phone, 0, 25)     ? $valid : false;
      $valid = XValidate::isMail($data->email, 1, 50)      ? $valid : false;
      $valid = XValidate::hasLength($data->subject, 1, 50) ? $valid : false;
      $valid = XValidate::hasLength($data->message, 1)     ? $valid : false;

      return $valid;
   }


   /**
    * Sends the e-mail to the set recipient
    *
    * @access private
    * @param $data Object containing the form data
    */
   private function _send($data) {
      global $xConf;

      // Sender (for correct replying)
      $sender = sprintf('%s %s', $data->title, $data->name);

      // Generate mail content
      $body = new XTemplate($this->_location());
      $body->assign('data', $data);
      $body->assign('xConf', $xConf);
      $body->assign('xLang', $this->xLang);
      $body = $body->fetch('templates/mail.tpl');

      // Sent e-mail
      $mail = new XMail($this->xConf->email, $this->xConf->subject, $body);
      $mail->setSender($data->email, $sender);
      $mail->setType('html');
      $mail->send();

   }

}
?>