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

      switch($this->xConf->compliance) {

         case 1:
            $this->_showCompliantTrackingCode();
            break;

         default:
            $this->_showNormalTrackingCode();
            break;

      }

   }


   /**
    * Shows the normal Asynchronous Tracking Code
    *
    * @access private
    */
   private function _showNormalTrackingCode() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->display('templates/normalTrackingCode.tpl');

   }


   /**
    * Shows the Cookie Consent compliant Tracking Code
    *
    * @access private
    */
   private function _showCompliantTrackingCode() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->display('templates/compliantTrackingCode.tpl');

   }

}
?>