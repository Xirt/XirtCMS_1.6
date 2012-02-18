<?php

/**
 * A class to search the database using 'FULLTEXT'
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class FullTextSearch extends Search {

   /**
    * Constructor
    *
    * @param $data The search data object (query)
    */
   function __construct(&$data) {

      $this->results = $this->_getItems($data->terms, $data->method);
      $this->results = $this->_filter($this->results, $data);
      $this->results = $this->_format($this->results, $data);
      $this->count = count($this->results);

   }


   /**
    * Prepares the given terms for usage in queries
    *
    * @access private
    * @param $terms The query terms entered by the user
    * @param $inclusive Toggles whether all terms should be found or not
    * @return Array The result(s) for this query
    */
   private function _parseterms($terms, $inclusive) {

      return $inclusive ? "+({$terms})" : $terms;
   }


   /**
    * Returns the requested search results
    *
    * @access private
    * @param $terms The query terms entered by the user
    * @param $inclusive Toggles whether all terms should be found or not
    * @return Array The result(s) for this query
    */
   private function _getItems($terms, $inclusive) {
      global $xConf, $xDb, $xUser;

      $score = "MATCH(title, content) AGAINST ('%s' IN BOOLEAN MODE)";
      $score = sprintf($score, $this->_parseTerms($terms, $inclusive));

      $query = "SELECT xid, title, content
                FROM #__staticcontent
                WHERE published = 1
                  AND access_min <= '{$xUser->rank}'
                  AND access_max >= '{$xUser->rank}'
                  AND language = '{$xConf->language}'
                  AND {$score}
                ORDER BY {$score} DESC";
      $xDb->setQuery($query);

      return $xDb->loadObjectList();
   }

}
?>