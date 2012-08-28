<?php

/**
 * Manager for XirtCMS templates
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
         case "show_content_list":
            new TemplatesController('TemplatesModel', 'TemplatesView', 'show');
            return;

         case "show_item":
            new TemplateController('TemplateModel', 'TemplateView', 'show');
            return;

         /*
          * Modify methods
          */
         case "add_item":
            new TemplateController('TemplateModel', null, 'add');
            return;

         case "edit_item":
            new TemplateController('TemplateModel', null, 'edit');
            return;

         case "edit_config":
            new TemplateController('TemplateModel', null, 'edit_config');
            return;

         case 'toggle_status':
            new TemplateController('TemplateModel', null, 'toggle_status');
            return;

         case 'toggle_active':
            new TemplatesController('TemplatesModel', null, 'unset_active');
            new TemplateController('TemplateModel', null, 'set_active');
            return;

         case "remove_item":
            new TemplateController('TemplateModel', null, 'delete');
            return;

      }

   }

}
?>