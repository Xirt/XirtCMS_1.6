<?php

/**
 * Class for monitoring the status of a file upload
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        XUpload
 */
class XUploadStatus {

   /**
    * The name of the sessions to use
    */
   const SESSION_KEY = '__upload_status';


   /**
    * CONSTRUCTOR
    *
    * @param $id A unique ID to identify the file upload
    */
   function __construct($id) {

      $this->id       = $id;
      $this->finished = false;
      $this->error    = false;
      $this->percent  = 0;

   }


   /**
    * Saves upload status to the session
    */
   function save() {
      $_SESSION[self::SESSION_KEY][$this->id] = $this;
   }


   /**
    * Retrieve upload status from the session
    */
   function load() {

      if (array_key_exists(self::SESSION_KEY, $_SESSION)) {

         if (array_key_exists($this->id, $_SESSION[self::SESSION_KEY])) {

            $session = $_SESSION[self::SESSION_KEY][$this->id];

            $this->finished = $session->finished;
            $this->error    = $session->error;
            $this->percent  = $session->percent;

         }

      }

   }

}
?>