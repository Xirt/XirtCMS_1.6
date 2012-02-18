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
    * @var The cId of this link
    */
   var $cid  = 0;


   /**
    * @var The language of this link
    */
   var $iso = null;


   /**
    * @var The query of the original link
    */
   var $query = null;


   /**
    * @var The alternative version of this link
    */
   var $alternative = null;


   /**
    * Create a new link (optionally filled with given values)
    *
    * @param $cId The cId of the link (optional)
    * @param $iso The language of the link (optional)
    * @param $query The original version of the link (optional)
    * @param $alt The SEF version of the link (optional)
    */
   function __construct($cId = 0, $iso = null, $query = null, $alt = null) {
      global $xConf;

      $this->cid         = intval($cId);
      $this->iso         = $iso;
      $this->query       = $query;
      $this->alternative = $alt;

   }


   /**
    * Fill this instance with the given values
    *
    * @param $query The query of the link
    * @param $name The name to use for the alternative link
    * @param $cId The cId of the link
    * @param $iso The language of the link
    * @return XLink This instance
    */
   function create($query, $name, $cId, $iso) {
      global $xConf, $xLinks;

      // Create link name (simplify given name)
      $name = strtolower(htmlentities($name, ENT_COMPAT, 'UTF-8'));
      $name = html_entity_decode($name, ENT_COMPAT, 'UTF-8');
      $name = strtr($name, XSEF::$conversions);
      $name = preg_replace('/[^\w-]/si', '', $name);

      // Create alternative link
      for ($i = 0; !$i || $xLinks->returnLinkByAlternative($link); $i++) {

         // Numbering for duplicate terms
         $link = $i ? sprintf('%s-%d', $name, $i) : $name;

         // If not primary language, add language to link
         if (current(Xirt::getLanguages())->iso != $xConf->language) {
            $link = sprintf('%s/%s', $xConf->language, $link);
         }

      }

      // Store values
      $this->cid         = $cId;
      $this->iso         = $iso;
      $this->query       = $query;
      $this->alternative = $link;

      return $this;
   }

   /**
    * Saves the links to the database
    */
   public function save() {
      global $xDb;

      return $xDb->insert('#__links', $this);
   }


   /**
    * Load SEF alternative from database
    *
    * @param $qry The query of the link to load
    * @return boolean True on success, false on failure
    */
   public function load($qry) {
      global $xDb;

      // Database query
      $query = 'SELECT *                 ' .
               'FROM #__links            ' .
               'WHERE alternative = :link';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':link', $qry, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      if ($dbRow = $stmt->fetchObject()) {

         foreach ($dbRow as $attrib => $value) {
            $this->$attrib = $value;
         }

         return false;
      }

      return true;
   }

}
?>