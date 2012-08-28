<?php

/**
 * Manager that shows the home (portal) of the administration section
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
      new PanelController('ErrorModel', 'PanelView', 'show');
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
            new LogController('LogModel', 'LogView', 'show');
            return;

         case 'show_item':
            new LogEntryController('LogEntryModel', 'LogEntryView', 'show');
            return;

         case 'show_log':
            new ErrorController('ErrorModel', 'ErrorView', 'show');
            return;

         /*
          * Modify methods
          */
         case 'remove_item':
            new LogEntryController('LogEntryModel', null, 'delete');
            return;

         case 'clear_errors':
            new ErrorController('ErrorModel', '', 'clear');
            break;

         case 'reset_notification':
            new ErrorController('ErrorModel', '', 'reset');
            break;

      }

   }

}
?>