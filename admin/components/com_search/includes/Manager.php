<?php

/**
 * Manager for XirtCMS search terms
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Manager {

   /**
    * Edits configuration for search engine
    */
   public static function editConfig() {
      global $xCom, $xDb;

      $config = (object) array();
      $config->search_type    = XTools::getParam('x_search_type',    0, _INT);
      $config->recording      = XTools::getParam('x_recording',      0, _INT);
      $config->default_value  = XTools::getParam('x_default_value',  '');
      $config->default_limit  = XTools::getParam('x_default_limit',  10, _INT);
      $config->default_method = XTools::getParam('x_default_method', 0, _INT);
      $config->titlelength    = XTools::getParam('x_titlelength',    250, _INT);
      $config->textlength     = XTools::getParam('x_textlength',     100, _INT);
      $config->node_id        = XTools::getParam('x_node_id',        0, _INT);

      // Save the right default method
		$method = 'x_default_method_' . $config->search_type;
      $config->default_method = XTools::getParam($method, 0, _INT);

      // Save values
      $config = array('config' => json_encode($config));
      $xDb->update('#__components', $config, "com_name = 'com_search'");

   }


   /**
    * Adds item
    */
   public static function addItem() {

      $list = new TermList();
      $list->load(XTools::getParam('nx_language'));

      $link = new Term();
      $link->set('impressions', XTools::getParam('nx_impressions', 0, _INT));
      $link->set('term',        XTools::getParam('nx_term'));
      $link->set('uri',         XTools::getParam('nx_uri'));
      $link->set('language',    XTools::getParam('nx_language'));
      $list->add($link);

   }


   /**
    * Edits item
    */
   public static function editItem() {
      global $xCom;

      $link = new Term();
      $link->load(XTools::getParam('id', 0, _INT));
      $link->set('impressions', XTools::getParam('x_impressions', 0, _INT));
      $link->set('term',        XTools::getParam('x_term'));
      $link->set('uri',         XTools::getParam('x_uri'));
      $link->save();

   }


   /**
    * Removes item
    */
   public static function removeItem() {

      $link = new Term();
      $link->load(XTools::getParam('id', 0, _INT));
      $link->remove();

   }

}
?>