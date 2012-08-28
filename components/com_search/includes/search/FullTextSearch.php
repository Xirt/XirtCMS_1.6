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
      $this->count = count($this->results);

      $this->results = $this->_filter($this->results, $data);
      $this->results = $this->_format($this->results, $data);

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

      $terms = $this->_parseTerms($terms, $inclusive);
      $score = "MATCH(title, content) AGAINST (:terms IN BOOLEAN MODE)";

      $query = 'SELECT xid, title, content  ' .
               'FROM #__content             ' .
               'WHERE published = 1         ' .
               '  AND access_min <= :rank   ' .
               '  AND access_max >= :rank   ' .
               '  AND language = :iso       ' .
               '  AND %s                    ' .
               'ORDER BY %s DESC            ';

      $stmt = $xDb->prepare(sprintf($query, $score, $score));
      $stmt->bindValue(':terms', $terms, PDO::PARAM_STR);
      $stmt->bindValue(':rank', $xUser->rank, PDO::PARAM_INT);
      $stmt->bindValue(':iso', $xConf->language, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
   }

}
?>