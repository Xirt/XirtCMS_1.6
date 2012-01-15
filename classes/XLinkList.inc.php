<?php

/**
 * Database Class for storing XLinks
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XLinkList {

   /**
    * @var Array containing all listed items
    */
   var $_list = array();


   /**
    * CONSTRUCTOR
    */
   function __construct() {
      $this->_load();
   }


   /**
    * Fills the list with items from the database
    *
    * @access private
    */
   function _load() {
      global $xDb;

      $query = "SELECT cid, iso, uri_ori, uri_sef
                FROM #__links";
      $xDb->setQuery($query);
      $dbObj = $xDb->loadObjectList();

      foreach ($dbObj ? $dbObj : array() as $dbRow) {

         $this->_list[] = new XLink(
            $dbRow->cid,
            $dbRow->iso,
            $dbRow->uri_ori,
            $dbRow->uri_sef
         );

      }

   }


   /**
    * Adds a link to the list (if not already existing)
    *
    * @param $cId Int with the cId of the page
    * @param $iso String with the language of the page
    * @param $original String with the original URL of the page
    * @param $name String with the search term for the URL
    */
   function add($cId, $iso, $original, $name) {
      global $xConf, $xDb;

      // Item already exists
      if ($this->returnLinkByLink($original, $iso)) {
         return;
      }

      // Create term (decode and remove special characters)
      $name = strtolower(htmlentities($name, ENT_COMPAT, "UTF-8"));
      $name = html_entity_decode($name, ENT_COMPAT, "UTF-8");
      $name = strtr($name, XSEF::$conversions);
      $name = preg_replace('/[^\w\d-]/si', '', $name);

      // Create link
      for ($i = 0; !$i || $this->returnLinkBySEF($name); $i++) {

         $name = $i ? $name . '-' . $i : $name;
         $link = $name . '.html';

         // Add language (SEF)
         if (current(Xirt::getLanguages())->iso != $xConf->language) {
             $link = $xConf->language . '/' . $link;
         }

      }

      $link = new XLink($cId, $xConf->language, $original, $link);
      $this->_list[] = $link;
      $link->save();

   }


   /**
    * Returns XLink by link (SEF)
    *
    * @param $link String holding the SEF variant of the link
    * @return mixed Returns the original XLink on success, null otherwhise
    */
   function returnLinkBySEF($link) {

      foreach ($this->_list as $item) {

         if ($item->uri_sef == $link) {
            return $item;
         }

      }

      return null;
   }


   /**
    * Returns XLink by original (normal)
    *
    * @param $original String holding the original link
    * @param $iso String holding the language of the link
    * @return mixed Returns the XLink on success, null otherwhise
    */
   function returnLinkByLink($original, $iso) {
      global $xConf;

      $iso = $iso ? $iso : $xConf->language;

      foreach ($this->_list as $item) {

         if ($item->uri_ori == $original && $item->iso == $iso) {
            return $item;
         }

      }

      return null;
   }

}
?>