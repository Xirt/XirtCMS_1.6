<?php

/**
 * Controller for sending e-mails
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MailController extends XController {

   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {

      if ($this->_model) {
         $this->_ready = $this->_model->load(XTools::getParam('id', 0, _INT));
      }

   }


   /**
    * Send the model as e-mail
    *
    * @access protected
    */
   protected function send() {

      // Load model
      if ($this->_model) {
         $this->_model->load();
      }

      // Send e-mail
      $mail = new Mail($this->_model);
      $mail->send();

   }

}
?>