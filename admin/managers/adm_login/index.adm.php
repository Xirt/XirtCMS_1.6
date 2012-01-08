<?php

require_once('includes/User.php');
require_once('includes/LoginManager.php');

/**
 * Manager for handling authentication (back-end)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      switch (XTools::getParam('task')) {

         case 'logout':
            LoginManager::logout();
            break;

         default:
            LoginManager::showLoginForm();
            break;

      }

   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         case 'forgot_password':
            LoginManager::showPasswordForm();
            break;

         case 'request_password':
            LoginManager::requestPassword();
            break;

         case 'attempt_login':
            LoginManager::login();
            break;

      }

   }

}
?>
