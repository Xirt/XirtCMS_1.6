<?php

/**
 * Manager for XirtCMS users
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package	   XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {
      new PanelController('PanelModel', 'PanelView', 'show');
   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         /*
          * View methods
          */
         case 'show_content_list':
            new UsersController('UsersModel', 'UsersView', 'show');
            return;

         case 'show_item':
            new UserController('UserModel', 'UserView', 'show');
            return;

         /*
          * Modify methods
          */
         case 'add_item':
            new UserController('UserModel', null, 'add');
            return;

         case 'edit_item':
            new UserController('UserModel', null, 'edit');
            return;

         case 'reset_password':
            new UserController('UserModel', null, 'reset');
            return;

         case 'remove_item':
            new UserController('UserModel', null, 'delete');
            return;

      }

   }

}
?>