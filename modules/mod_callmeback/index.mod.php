<?php

/**
 * Call-Me-Back layover for your website (called using JavaScript)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 -2012
 * @package    XirtCMS
 */
class mod_callmeback extends XModule {

   /**
    * Shows the content
    */
   function showNormal() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('xLang', $this->xLang);
      $tpl->display('templates/template.tpl');

   }


   /**
    * Shows the AJAX content
    */
   function showAJAX() {
      global $xConf;

      // Retrieve data
      $data          = (Object)array();
      $data->name    = XTools::getParam('x_name');
      $data->company = XTools::getParam('x_company');
      $data->phone   = XTools::getParam('x_phone');

      if (strlen($data->name) && XValidate::isPhone($data->phone)) {

      	// Generate mail content
         $body = new XTemplate($this->_location());
         $body->assign('data', $data);
         $body->assign('xConf', $xConf);
         $body->assign('xLang', $this->xLang);
         $body = $body->fetch('templates/mail-request.tpl');

         // Sent e-mail
         $mail = new XMail($this->xConf->email, $this->xConf->subject, $body);
         $mail->setType('html');
         $mail->send();

      }

   }

}
?>