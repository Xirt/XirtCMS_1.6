<?php

/**
 * Manager for XirtCMS content viewer
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Manager {

   /**
    * Edits configuration
    */
   public static function save() {
      global $xCom, $xDb;

      $data = array(

         'config' => json_encode((object)array(
            'css_name'      => XTools::getParam('item_css_name'),
            'show_title'    => XTools::getParam('item_show_title',    0, _INT),
            'show_author'   => XTools::getParam('item_show_author',   0, _INT),
            'show_created'  => XTools::getParam('item_show_created',  0, _INT),
            'show_modified' => XTools::getParam('item_show_modified', 0, _INT),
            'download_icon' => XTools::getParam('item_download_icon', 0, _INT),
            'print_icon'    => XTools::getParam('item_print_icon',    0, _INT),
            'mail_icon'     => XTools::getParam('item_mail_icon',     0, _INT),
            'back_icon'     => XTools::getParam('item_back_icon',     0, _INT)
         ))

      );

      $xDb->update('#__components', $data, "type = 'com_content'");

   }

}
?>
