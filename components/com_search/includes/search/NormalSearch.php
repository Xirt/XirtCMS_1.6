<?php

/**
 * A class to search the database regularly (using the 'LIKE'-expression)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class NormalSearch extends Search {

   /**
    * Constructor
    *
    * @param $data The search data object (query)
    */
   function __construct(&$data) {

      $this->results = $this->_getItems($data);
      $this->count = count($this->result);

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

      return $inclusive? "+({$terms})" : $terms;
   }


   /**
    * Returns the requested search results
    *
    * @access private
    * @param $terms The query terms entered by the user
    * @param $inclusive Toggles whether all terms should be found or not
    * @return Array The result(s) for this query
    */
   private function _getItems(&$data) {
      global $xConf, $xDb, $xUser;

      $data->terms = XTools::addslashes($data->terms);
      $restriction = $this->_getComplexTerm($data->method, $data->terms);

      $terms = array();
      $terms[] = str_replace('%field%', 'title',            $restriction);
      $terms[] = str_replace('%field%', 'content',          $restriction);
      $terms[] = str_replace('%field%', 'meta_keywords',    $restriction);
      $terms[] = str_replace('%field%', 'meta_description', $restriction);
      $terms = implode(' OR ', $terms);

      $query = 'SELECT xid, title, content  ' .
               'FROM #__content             ' .
               'WHERE published = 1         ' .
               '  AND access_min <= :rank   ' .
               '  AND access_max >= :rank   ' .
               '  AND language = :iso       ' .
               '  AND %s                    ';

      $stmt = $xDb->prepare(sprintf($query, $terms));
      $stmt->bindValue(':terms', $terms, PDO::PARAM_STR);
      $stmt->bindValue(':rank', $xUser->rank, PDO::PARAM_INT);
      $stmt->bindValue(':iso', $xConf->language, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
   }


   /**
    * Returns a complex query part for the WHERE-clause
    *
    * @access private
    * @param $method The method to use for this search
    * @param $term The query terms entered by the user
    * @return String Returns the generated query part
    */
   private function _getComplexTerm($method, $terms) {

      $logic = array(' AND ', ' OR ', ' XOR ');

      if (!array_key_exists($method - 1, $logic)) {
         return "%field% LIKE '%{$terms}%'";
      }

      // Split search terms
      $restrictions = array();
      foreach(explode(' ', $terms) as $term) {
         $restrictions[] = "%field% LIKE '%{$term}%'";
      }

      return implode($logic[$method - 1], $restrictions);
   }

}
?>