<?php

/**
 * Manager for XirtCMS languages
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

      switch (XTools::getParam("task")) {

         /*
          * View methods
          */
         case 'show_content_list':
            new LanguagesController('LanguagesModel', 'LanguagesView', 'show');
            return;


         /*
          * Modify methods
          */
         case 'move_up':
            new LanguagesController('LanguagesModel', null, 'moveUp');
            return;

         case 'move_down':
            new LanguagesController('LanguagesModel', null, 'moveDown');
            return;

         case 'toggle_status':
            new LanguageController('LanguageModel', null, 'toggle');
            return;

      }

   }

}
?>