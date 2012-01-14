<?php

/**
 * Class to send recommendation e-mails
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Mail {

   /**
    * Constructor
    *
    * @param $item The Content for the e-mail
    */
   function __construct($item) {
      $this->item = $item;
   }


   /**
    * Attempts to send the e-mail
    *
    * @return boolean True on success, false on failure
    */
   public function send() {

      if (($data = $this->_receive()) && $this->_check($data)) {
         return $this->_send($data);
      }

      return false;
   }


	/**
    * Captures the form data in an object
    *
    * @access private
    * @return Object containing form data or null on failure
    */
   private function _receive() {

      $data          = (Object)array();
      $data->url      = self::_getLink($this->item);
      $data->name     = XTools::getParam('x_name');
      $data->rec_name = XTools::getParam('x_rec_name');
      $data->rec_mail = XTools::getParam('x_rec_mail');

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
      $valid = XValidate::hasLength($data->name, 1, 50)     ? $valid : false;
      $valid = XValidate::hasLength($data->rec_name, 1, 50) ? $valid : false;
      $valid = XValidate::isMail($data->rec_mail, 1, 50)    ? $valid : false;

      return $valid;
   }


   /**
    * Sends the e-mail to the set recipient
    *
    * @private
    * @param data Object containing the form data
    */
   private function _send($data) {
      global $xCom, $xConf;

      // Subject
      $subject = vsprintf($xCom->xLang->misc['subject'], $data->name);
      $subject = html_entity_decode($subject, ENT_QUOTES);

      // Content
      $content = new Template();
      $content->assign('data', $data);
      $content->assign('xConf', $xConf);
      $content->assign('xLang', $xCom->xLang);
      $content = $content->fetch('mail.tpl');
      $content = html_entity_decode($content, ENT_QUOTES);

      // Sent mail
      $mail = new XMail($data->rec_mail, $subject, $content);
      $mail->setType('html');
      $mail->send();

   }


   /**
    * Returns the link for the given item
    *
    * @access private
    * @param $item The ContenItem to retrieve the link for
    * @return String The link to the given item
    */
	private static function _getLink($item) {
	   global $xConf;

	   return $xConf->siteURL . "index.php?content=com_content&id=" . $item->id;
	}

}
?>
