<?php

/**
 * Controller for Login Sessions
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LoginController extends XController {

   /**
    * Attempt to login using the Model
    *
    * @access protected
    */
   protected function login() {
      global $xCom;

      $user = XTools::getParam('user_name');
      $pass = XTools::getParam('user_pass');

      if (!XAuthentication::create($user, $pass)) {
         die($xCom->xLang->messages['loginFail']);
      }

   }


   /**
    * Attempts to logout using the Model
    *
    * @access protected
    */
   protected function logout() {

      XAuthentication::destroy();
      header('Location: index.php');

   }

}
?>