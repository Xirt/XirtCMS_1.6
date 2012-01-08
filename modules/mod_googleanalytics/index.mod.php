<?php

/**
 * Includes the GA tracking code on a website (not visible)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_googleanalytics extends XModule {

   /**
    * Shows the content
    */
   function showNormal() {

      switch($this->xConf->code_type) {

         case 1:
            $this->_showNewTrackingCode();
            break;

         case 2:
            $this->_showLegacyTrackingCode();
            break;

         case 3:
         default:
            $this->_showAsyncTrackingCode();
            break;

      }

   }


   /**
    * Shows the Asynchronous Tracking Code (recommended)
    *
    * @access private
    */
   private function _showAsyncTrackingCode() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->display('templates/asynchronousTrackingCode.tpl');

   }


   /**
    * Shows the New Tracking Code
    *
    * @access private
    */
   private function _showNewTrackingCode() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->display('templates/newTrackingCode.tpl');

   }


   /**
    * Shows the Legacy Tracking Code
    *
    * @access private
    */
   private function _showLegacyTrackingCode() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->display('templates/legacyTrackingCode.tpl');

   }

}
?>
