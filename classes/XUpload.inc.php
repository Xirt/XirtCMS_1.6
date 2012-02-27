<?php

/**
 * Class to keep track of uploads (progress bar)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package	   XirtCMS
 * @see        XUploadStatus
 */
class XUpload {

   /**
    * The APC identifier to use
    */
   const ID_KEY = 'APC_UPLOAD_PROGRESS';


   /**
    * CONSTRUCTOR
    *
    * @param $id A unique ID to identify the file upload
    */
   public function __construct($id) {

      $this->id = $id;
      $this->status = new XUploadStatus($id);
      $this->status->load();

   }


   /**
    * Moves upload to a specified folder
    *
    * @param $name The name of the uploaded file (form field)
    * @param $path The destination path of the file (directory)
    */
   public function move($name, $path) {

      if (!$err = $this->_getErrors($name)) {

         $fileInfo = $_FILES[$name];
         $path = $path . basename($fileInfo['name']);

         if (!move_uploaded_file($fileInfo['tmp_name'], $path)) {

            trigger_error("Upload failure ({$path})", E_USER_WARNING);
            $err = $xLang->errors['uploadFail'];

         }

      }

      $this->status->finished = true;
      $this->status->percent = 100;
      $this->status->error = $err;
      $this->status->save();

      return true;
   }


   /**
    * Returns errors occurred during the transfer
    *
    * @return mixed Returns the status of the transfer
    */
   public function getStatus() {

      // No APC
      if (!self::_isCompatible() || $this->status->finished) {
         return $this->status;
      }

      // Failed APC
      if (!$transfer = apc_fetch('upload_' . $this->id)) {
         return $this->status;
      }

      // Retrieve status
      if ($transfer['total'] > 0) {

         $percentage = $transfer['current'] / $transfer['total'] * 100;
         $this->status->finished = ($percentage == 100);
         $this->status->percent = round($percentage, 2);
         $this->status->save();

      }

      return $this->status;
   }


   /**
    * Returns errors occurred during the transfer
    *
    * @access private
    * @param $name The name of the uploaded file (form field)
    * @return mixed Returns false on success, the error on failure
    */
   private function _getErrors($name) {
      global $xLang;

      if (!array_key_exists($name, $_FILES) || !is_array($_FILES[$name])) {
         return $xLang->errors['uploadFail'];
      }

      switch($_FILES[$name]['error']) {

         case UPLOAD_ERR_OK:
            return false;
            break;

         case UPLOAD_ERR_INI_SIZE:
         case UPLOAD_ERR_FORM_SIZE:
            return $xLang->errors['uploadSize'];
            break;

         case UPLOAD_ERR_NO_TMP_DIR:
         case UPLOAD_ERR_CANT_WRITE:
            trigger_error($xLang->errors['uploadWrite'], E_USER_WARNING);
            return $xLang->errors['uploadWrite'];
            break;

         case UPLOAD_ERR_PARTIAL:
         case UPLOAD_ERR_NO_FILE:
            trigger_error($xLang->errors['uploadFail'], E_USER_NOTICE);
            return $xLang->errors['uploadFail'];
            break;

      }

      return $xLang->errors['generalFail'];
   }


   /**
    * Checks whether the APC module is installed and available on the server
    *
    * @access private
    * @return boolean Returns true if APC is available on the server
    */
   private function _isCompatible() {

      if (!extension_loaded('apc') || !function_exists('apc_fetch')) {
         return false;
      }

      return ini_get('apc.enabled') && ini_get('apc.rfc1867');
   }

}
?>