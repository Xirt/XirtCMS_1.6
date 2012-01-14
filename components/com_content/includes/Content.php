<?php

/**
 * Holds information on a content item
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        ContentViewer
 */
class Content {

   /**
    * @var Defines whether the instance is a translation of the content or not
    */
   var $translation = false;


   /**
    * Load the item from the database
    *
    * @param $id int that holds the xId of the item to load
    * @return boolean Return true on success, false on failure
    */
   public function load($id) {
      global $xConf, $xDb;

      $query = "SELECT *
                FROM (
                   SELECT t1.*, t2.preference
                   FROM #__staticcontent AS t1
                   INNER JOIN #__languages AS t2 ON t1.language = t2.iso
                   ORDER BY t2.preference, t1.xid
                ) AS t3
                WHERE t3.published = 1
                   AND xid = {$id}";
      $xDb->setQuery($query);

      if ($dbObj = $xDb->loadObjectList('language')) {

         if (array_key_exists($xConf->language, $dbObj)) {

            $this->_init($dbObj[$xConf->language]);
            return true;

         }

         $this->_init(current($dbObj));
         return true;

      }

      return false;
   }


   /**
    * Initializes instance with given data
    *
    * @access private
    * @param $data Object containing data to initialize instance
    */
   private function _init($data) {
      global $xConf;

      foreach ($data as $name => $value) {
         $this->$name = $value;
      }

      // Variables parsing
      $this->translation = ($data->language != $xConf->language);
      $this->config      = $this->_parseConfiguration($this->config);
      $this->content     = $this->_parseContent($this->content);

      // Creation date
      if ($this->config->show_created) {

         $this->created = new DateTime($this->created);
         $this->created = $this->created->format('U');
         $this->created = XTools::getFullDate($this->created, true);

      }

      // Modification date
      if ($this->config->show_modified) {

         $modified = new DateTime($this->modified);
         $modified = $modified->format('U');
         $this->modified = XTools::getFullDate($modified, true);
         $this->modified = ($modified > 0) ? $this->modified : 0;

      }

   }


   /**
    * Sets the configuration of the item
    *
    * @access private
    * @param $config The configuration to parse
    * @return String the parsed configuration
    */
   private function _parseConfiguration($config) {
      global $xCom;

      $list = (Object)array();
      foreach (json_decode($config) as $key => $val) {

         $val = ($val == -1) ? $xCom->xConf->$key : $val;
         $list->$key = $val;

      }

      return $list;
   }


   /**
    * Parses the given content
    *
    * @access private
    * @param $content The content to parse
    * @return String the parsed content
    */
   private function _parseContent($content) {
      return XSEF::parse($content);
   }

}
?>
