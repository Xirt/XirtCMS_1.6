<?php

/**
 * Manager for XirtCMS Search Terms
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Component extends XComponent {

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
            new TermsController('TermsModel', 'TermsView', 'show');
            return;

         case 'show_item':
            new TermController('TermModel', 'TermView', 'show');
            return;


         /*
          * Modify methods
          */
         case 'add_item':
            new TermController('TermModel', null, 'add');
            return;

         case 'edit_item':
            new TermController('TermModel', null, 'edit');
            return;

         case 'edit_config':
            new ComponentController('ComponentModel', null, 'edit');
            return;

         case 'remove_item':
            new TermController('TermModel', null, 'delete');
            return;

      }

   }

}
?>