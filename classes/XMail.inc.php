<?php

/**
 * Class for generating and sending e-mails
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XMail {

   /**
    * @var String containing the sender e-mail address
    */
   var $sender = null;


   /**
    * @var String containing the recipient
    */
   var $recipient = null;


   /**
    * @var Array containing all CC recipients
    */
   var $cc = array();


   /**
    * @var Array containing all BCC recipients
    */
   var $bcc = array();


   /**
    * @var The subject of the e-mail
    */
   var $subject = null;


   /**
    * @var The body of the e-mail (content)
    */
   var $body = array();


   /**
    * @var Array containing all mail headers
    */
   var $headers = array();


   /**
    * @var Array containing the attachments
    */
   var $attachments = array();


   /**
    * @var Toggles use of plaintext / HTML
    */
   var $plainText = true;


   /**
    * Class for generating and sending e-mails
    *
    * @param $recipient The recipient of the e-mail
    * @param $subject The subject of the e-mail (optional, defaults null)
    * @param $body The content of the e-mail (optional, defaults null)
    */
   function __construct($recipient, $subject = null, $body = null) {
      global $xConf;

      $this->recipient = $recipient;
      $this->subject   = $subject;
      $this->body      = $body ? array($body) : array();

      // Default headers
      $this->setHeader('X-Mailer', 'PHP/' . phpversion());
      $this->setSender($xConf->fromMail, $xConf->fromName);

   }


   /**
    * Sets the type of body of the e-mail (plain / HTML)
    *
    * @param $toggle The body type (optional, default: plain)
    */
   function setType($toggle = 'plain') {

      $this->plainText = ($toggle == 'plain') ? true : false;

   }


   /**
    * Returns true if the mail is in plain text
    *
    * @param boolean True if plain, false otherwhise
    */
   function isPlain() {

      return $this->plainText;

   }


   /**
    * Returns true if the mail is in html
    *
    * @param boolean True if html, false otherwhise

    */
   function isHTML() {

      return !$this->plainText;
   }


   /**
    * Adds / Replaces header of e-mail
    *
    * @param $type The header
    * @param $value The value (setting) of the header
    */
   function setHeader($type, $value) {
      $this->headers[$type] = $value;
   }


   /**
    * Sets the sender of the e-mail
    *
    * @param $addr String containing the sender of the e-mail
    * @param $name String containing the name of the sender (optional)
    */
   function setSender($addr, $name = null) {

      if (XValidate::isMail($addr)) {
         $this->sender = isset($name) ? "{$name} <{$addr}>" : $addr;
      }

   }


   /**
    * Sets the recipient of the e-mail
    *
    * @param $addr String containing the recipient of the e-mail
    * @param $name String containing the name of the recipient (optional)
    */
   function setRecipient($addr, $name = null) {

      if (isset($name) && XValidate::isMail($addr)) {
         return ($this->recipient = "{$name} <{$addr}>");
      }

      $this->recipient = $addr;
   }


   /**
    * Adds a Carbon Copy (Cc) recipient to the e-mail
    *
    * @param $addr String containing the CC recipient of the e-mail
    * @param $name String containing the name of the CC recipient (optional)
    */
   function addCC($addr, $name = null) {

      if (isset($name) && XValidate::isMail($addr)) {
         return ($this->cc[] = "{$name} <{$addr}>");
      }

      $this->cc[] = $addr;
   }


   /**
    * Adds a Blind Carbon Copy (Bcc) recipient to the e-mail
    *
    * @param $addr String containing the BCC recipient of the e-mail
    * @param $name String containing the name of the BCC recipient (optional)
    */
   function addBCC($addr) {

      if (isset($name) && XValidate::isMail($addr)) {
         return ($this->bcc[] = "{$name} <{$addr}>");
      }

      $this->bcc[] = $addr;
   }


   /**
    * Sets the subject of the e-mail
    *
    * @param $subject String containing the subject
    */
   function setSubject($subject) {
      $this->subject = $subject;
   }


   /**
    * Sets the body of the e-mail
    *
    * @param $body String containing the body
    */
   function setBody($body) {
      $this->body = array($body);
   }


   /**
    * Extends the body of the e-mail
    *
    * @param $body String containing the body extension
    */
   function extendBody($body = null) {
      $this->body[] = $body;
   }


   /**
    * Adds an attachment to the e-mail
    *
    * @param $file The location of the file to add
    * @return boolean True on succes, false otherwhise
    */
   function addFile($file) {

      if (!$type = @filetype($file)) {

         trigger_error("Type retrieval failed ({$file})", E_USER_WARNING);
         return false;

      }

      if (!$data = @file_get_contents($file)) {

         trigger_error("Content retrieval failed ({$file})", E_USER_WARNING);
         return false;

      }

      $name = basename($file);
      $data = chunk_split(base64_encode($data));
      $this->attachments[] = array($file, $type, $data);

      return true;
   }


   /**
    * Sends the e-mail
    */
   function send() {

      if ($this->plainText) {

         $body = implode("\n", $this->body);
         $body = wordwrap($body, 70);
         $this->setHeader('Content-type', 'text/plain; charset=UTF-8');

      } else {

         $body = implode("\n", $this->body);
         $this->setHeader('MIME-Version', '1.0');
         $this->setHeader('Content-type', 'text/html; charset=UTF-8');

      }

      if ($this->attachments) {

         ob_start();
         $hash = md5(microtime());
         $content = "multipart/mixed; boundary=\"PHP-mixed-%s\"";
         $this->setHeader('Content-type', sprintf($content, $hash));

         // Plain
         //echo nl. "--PHP-mixed-{$hash}";
         //echo nl. "Content-Type: text/plain; charset=\"iso-8859-1\"";
         //echo nl. "Content-Transfer-Encoding: 7bit";
         //echo nl;
         //echo nl. $body;

         // HTML
         echo nl. "--PHP-mixed-{$hash}";
         echo nl. "Content-Type: text/html; charset=\"UTF-8\"";
         echo nl. "Content-Transfer-Encoding: 7bit";
         echo nl;
         echo nl. $body;

         foreach ($this->attachments as $file) {

            echo nl;
            echo nl. "--PHP-mixed-{$hash}";
            echo nl. "Content-Type: application/octet-stream; name={$file[0]}";
            echo nl. "Content-Transfer-Encoding: base64";
            echo nl. "Content-Disposition: attachment";
            echo nl;
            echo nl. $file[2];

         }

         echo nl. "--PHP-mixed-{$hash}--";
         $body = ob_get_flush();

      }

      $headers = array();
      foreach ($this->headers as $type => $value) {

         $headers[] = $type . ':' . $value;

      }

      $headers[] = 'Cc:' . implode(',', $this->cc);
      $headers[] = 'Bcc:' . implode(',', $this->bcc);
      $headers[] = 'From:' . $this->sender;
      $headers[] = 'Reply-To:' . $this->sender;
      $headers = implode("\r\n", $headers);

      if (!@mail($this->recipient, $this->subject, $body, $headers)) {

         trigger_error("XMail failed ({$this->recipient}).", E_USER_WARNING);
         return false;

      }

      return true;
   }

}
?>