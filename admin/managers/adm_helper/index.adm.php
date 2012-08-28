<?php

/**
 * Class assisting with various tasks
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package	   XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         case 'show_upload_progress':
            $this->showUploadProgress();
            return;

      }

   }


   /**
    * Returns the status of a file upload (defined by posted ID)
    *
    * @access private
    */
   private function showUploadProgress() {

      $id = XTools::getParam('id', 0, _INT);
      $transfer = new XUpload($id);

      header('Content-type: application/json');
      print(json_encode($transfer->getStatus()));

   }

}
?>