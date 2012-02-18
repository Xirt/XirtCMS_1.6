<?php

/**
 * A class to search the database (to be extended)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Search {

   /**
    * @var Base URL for regular content items
    */
   const URL_CONTENT = "index.php?content=com_content&id=%d";


   /**
    * Resizes the set of results according to the users preferences
    *
    * @param $results The current set of results
    * @param $data The search data object (query)
    * @return Array The new set of results
    */
   protected function _filter(&$results, &$data) {
      return array_slice($results, $data->start, $data->limit);
   }


   /**
    * Formats all search items with links, max length etc.
    *
    * @param $results The current set of results
    * @return Array The new set of results
    */
   protected function _format(&$results) {                                      // Herschrijven
      global $xCom;

      $menuNodes = $this->_getNodes();

      foreach ($results as $result) {

         $result->link = sprintf(self::URL_CONTENT, $result->xid);

         // Get item cId
         $cId = 0;
         foreach ($menuNodes as $menuNode) {

            if ($menuNode->link == $result->link) {
               $cId = $menuNode->xid;
            }

         }

         $result->content = XTools::createSummary(
            strip_tags($result->content),
            $xCom->xConf->textlength
         );

         $result->link = XTools::createLink(
            $result->link,
            $cId,
            $result->title
         );

         $result->title = XTools::createSummary(
            $result->title,
            $xCom->xConf->titlelength
         );

      }

      return $results;
   }


   /**
    * Returns all menu links
    *
    * @access private
    * @return Array containing all known menu nodes
    */
   private function _getNodes() {
      global $xDb, $xUser;

      $query = "SELECT xid, link
                FROM #__menunodes
                WHERE published = '1'
                  AND access_min <= '{$xUser->rank}'
                  AND access_max >= '{$xUser->rank}'";
      $xDb->setQuery($query);

      return $xDb->loadObjectList();
   }

}
?>