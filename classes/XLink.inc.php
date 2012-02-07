<?php

/**
 * Class holding information about a (SEF) link
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XLink {

   /**
    * @var The cId of the link
    */
   var $cid  = 0;


   /**
    * @var The language of the link
    */
   var $iso = null;


   /**
    * @var The original version of the link
    */
   var $uri_ori = null;


   /**
    * @var The SEF version of the link
    */
   var $uri_sef = null;


   /**
    * CONSTRUCTOR
    *
    * @param $cId The cId of the link (optional, defaults 0)
    * @param $iso The language of the link (optional)
    * @param $original The original version of the link (optional)
    * @param $link The SEF version of the link (optional)
    */
   function __construct($cId = 0, $iso = null, $original = null, $link = null) {
      global $xConf;

      $this->cid     = intval($cId);
      $this->iso     = $iso;
      $this->uri_sef = $link;
      $this->uri_ori = $original;

      if (!$this->uri_ori || !$this->iso) {
         $this->_get();
      }

   }


   /**
    * Saves the links to the database
    */
   public function save() {
      global $xDb;

      $xDb->insert('#__links', $this);

   }


   /**
    * Load SEF alternative from database
    *
    * @access private
    * @return boolean True on success, false on failure
    */
   private function _get() {
      global $xDb;

      // Database query
      $query = 'SELECT cid, iso, uri_ori ' .
               'FROM #__links            ' .
               'WHERE uri_sef = :link    ';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':link', $this->uri_sef, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      if ($dbRow = $stmt->fetchObject()) {

         $this->iso     = $dbRow->iso;
         $this->cid     = $dbRow->cid;
         $this->uri_ori = $dbRow->uri_ori;

         return false;
      }

      return true;
   }

}
?>