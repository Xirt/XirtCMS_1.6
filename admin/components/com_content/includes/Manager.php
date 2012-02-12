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
            'show_title'    => XTools::getParam('item_show_title',    _INT, 0),
            'show_author'   => XTools::getParam('item_show_author',   _INT, 0),
            'show_created'  => XTools::getParam('item_show_created',  _INT, 0),
            'show_modified' => XTools::getParam('item_show_modified', _INT, 0),
            'download_icon' => XTools::getParam('item_download_icon', _INT, 0),
            'print_icon'    => XTools::getParam('item_print_icon',    _INT, 0),
            'mail_icon'     => XTools::getParam('item_mail_icon',     _INT, 0),
            'back_icon'     => XTools::getParam('item_back_icon',     _INT, 0)
         ))

      );

      $xDb->update('#__components', $data, "com_name = 'com_content'");

   }

}
?>