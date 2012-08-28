<?php

/**
 * Manager for handling authentication (back-end)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      switch (XTools::getParam('task')) {

         case 'logout':
            new LoginController(null, null, 'logout');

         default:
            new PanelController(null, 'PanelView', 'show');
            break;

      }

   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         case 'attempt_login':
            new LoginController(null, null, 'login');
            break;

         case 'request_password':
            new UserController('UserModel', null, 'reset');
            break;

      }

   }

}
?>