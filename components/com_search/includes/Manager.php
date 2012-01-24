<?php

/**
 * Library to retrieve search results from query
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Manager {

   /**
    * Returns search data (with terms escaped)
    *
    * @return Array containing the search data
    */
   public static function getSearchData() {

      $data = (object) array();
      $data->page   = XTools::getParam('page', 0, _INT);
      $data->terms  = XTools::getParam('q', '', _STRING);
      $data->limit  = XTools::getParam('limit', 10, _INT);
      $data->method = XTools::getParam('method', 0, _INT);
      $data->start  = $data->page * $data->limit;
      $data->count  = 0;

      // Validation data
      $data->page  = abs($data->page);
      $data->limit = max(abs($data->limit), 100);
      $data->terms = XTools::addslashes($data->terms);

      return $data;
   }


   /**
    * Returns the searched items items
    *
    * @param $data The search data object (query)
    * @return Mixed Containing the searched results or null on failure
    */
   public static function getSearchResults(&$data) {
      global $xCom, $xConf, $xDb;

      if (!trim($data->terms)) {
         return null;
      }

      switch ($xCom->xConf->search_type) {

         case "fulltext":
            $result = new FullTextSearch($data);
            self::_record($data, $result);
         break;

         default:
            $result = new NormalSearch($data);
            self::_record($data, $result);
         break;

      }

      return $result;
   }


   /**
    * Records the current search query (if activated)
    *
    * @param $data The search data object (query)
    * @param $result Object containing the search results
    */
   protected static function _record(&$data, &$result) {
      global $xCom, $xConf, $xDb;

      if (!$xCom->xConf->recording) {
         return;
      }

      // Update existing record
      $query = "UPDATE #__search
      	       SET impressions = impressions + 1
      	       WHERE term = '{$data->terms}'";
      $xDb->setQuery($query);
      $xDb->query();

      // New record (only on search results)
      if (!$xDb->rowCount() && $result->count) {

         $xDb->insert("#__search", array(
            'term'        => $data->terms,
            'language'    => $xConf->language,
            'uri'         => $result->results[0]->link,
            'impressions' => 1,
            'published'   => 1
         ));

      }

   }

}
?>