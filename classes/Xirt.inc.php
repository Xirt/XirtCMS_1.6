<?php

/**
 * Utility class with abstract functions to support XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        XCache
 */
class Xirt {

   /**
    * Clears the internal Xirt cache
    */
   public static function clearCache() {
      global $xCache;

      $xCache->get('menus');
      $xCache->get('ranks');
      $xCache->get('modules');
      $xCache->get('languages');
      $xCache->get('templates');
      $xCache->get('components');

   }


   /**
    * Returns available languages (ordered by preference) - results are cached
    *
    * @param $currentOnTop If true, the current language will be the first item
    * @return Object List containing language details
    */
   public static function getLanguages($currentOnTop = false) {
      global $xCache, $xConf, $xDb;

      if (!$list = $xCache->get('languages')) {

         // Database query
         if (defined('_ADMIN')) {

            $query = 'SELECT *               ' .
                     'FROM #__languages      ' .
                     'ORDER BY preference ASC';

         } else {

            $query = 'SELECT *               ' .
                     'FROM #__languages      ' .
                     'WHERE published = 1    ' .
                     'ORDER BY preference ASC';

         }

         // Retrieve data
         $stmt = $xDb->prepare($query);
         $stmt->execute();

         // Create list
         $list = array();
         while ($dbRow = $stmt->fetchObject()) {
            $list[$dbRow->iso] = $dbRow;
         }

         $xCache->set('languages', $list);

      }

      // Optionally sort list
      if ($currentOnTop && array_key_exists($xConf->language, $list)) {

         $current = $list[$xConf->language];
         $current = array($current->iso => $current);
         $list = $current + $list;

      }

      return $list;
   }


   /**
    * Returns all templates (ordered by active, published) - results are cached
    *
    * @return Object List containing template details
    */
   public static function getTemplates() {
      global $xCache, $xDb;

      if (!$templates = $xCache->get('templates')) {

         // Database query
         if (defined('_ADMIN')) {

            $query = 'SELECT *                            ' .
                     'FROM #__templates                   ' .
                     'ORDER BY active DESC, published DESC';

         } else {

            $query = 'SELECT *                            ' .
                     'FROM #__templates                   ' .
                     'WHERE published = 1                 ' .
                     'ORDER BY active DESC                ';

         }

         // Retrieve data
         $stmt = $xDb->prepare($query);
         $stmt->execute();

         // Create list
         $list = array();
         while ($dbRow = $stmt->fetchObject()) {
            $list[$dbRow->folder] = $dbRow;
         }

         $xCache->set('templates', $list);

      }

      return $list;
   }


   /**
    * Returns all usergroups (starting at lowest) - results are cached
    *
    * @return Object List containing all usergroups
    */
   public static function getRanks() {
      global $xCache, $xDb;

      if (!$list = $xCache->get('ranks')) {

         // Query (selection)
         $query = 'SELECT name, rank                                     ' .
                  'FROM (%s) AS subset                                   ' .
                  'GROUP BY rank                                         ' .
                  'ORDER BY rank                                         ';

         // Subquery (translations)
         $trans = 'SELECT t1.*                                           ' .
                  'FROM #__usergroups AS t1                              ' .
                  'INNER JOIN #__languages AS t2 ON t1.language = t2.iso ' .
                  'ORDER BY t2.preference, t1.rank                       ';

         // Retrieve data
         $stmt = $xDb->prepare(sprintf($query, $trans));
         $stmt->execute();

         // Create list
         $list = array();
         while ($dbRow = $stmt->fetchObject()) {
            $list[$dbRow->rank] = $dbRow;
         }

         $xCache->set('ranks', $list);

      }

      return $list;
   }


   /**
    * Returns all menus - results are cached
    *
    * @return Object List containing all menus
    */
   public static function getMenus() {
      global $xCache, $xDb;

      if (!$list = $xCache->get('menus')) {

         // Query (selection)
         $query = 'SELECT *                                              ' .
                  'FROM (%s) AS subset                                   ' .
                  'GROUP BY xid                                          ' .
                  'ORDER BY ordering ASC                                 ';

         // Subquery (translations)
         $trans = 'SELECT t1.*                                           ' .
                  'FROM #__menus AS t1                                   ' .
                  'INNER JOIN #__languages AS t2 ON t1.language = t2.iso ' .
                  'ORDER BY t2.preference, t1.ordering                   ';

         // Retrieve data
         $stmt = $xDb->prepare(sprintf($query, $trans));
         $stmt->execute();

         // Create list
         $list = $stmt->fetchAll(PDO::FETCH_OBJ);
         $xCache->set('menus', $list);

      }

      return $list;
   }


   /**
    * Returns available components - results are cached
    *
    * @return Object List containing component details
    */
   public static function getComponents() {
      global $xCache, $xDb;

      if (!$list = $xCache->get('components')) {

         // Database query
         $query = 'SELECT *          ' .
                  'FROM #__components';

         // Data retrieval
         $stmt = $xDb->prepare($query);
         $stmt->execute();

         // Create list
         $list = array();
         while ($dbRow = $stmt->fetchObject()) {
            $list[$dbRow->com_name] = $dbRow;
         }

         $xCache->set('components', $list);

      }

      return $list;
   }


   /**
    * Returns all modules (ordered by publishing status) - results are cached
    *
    * @return Object List containing module details
    */
   public static function getModules() {
      global $xCache, $xDb, $xUser;

      if (!$list = $xCache->get('modules')) {

         if (defined('_ADMIN')) {

            // Database query
            $query = 'SELECT *                         ' .
                     'FROM #__modules                  ' .
                     'ORDER BY published DESC, ordering';

            // Data retrieval
            $stmt = $xDb->prepare($query);
            $stmt->execute();

         } else {

            // Database query
            $query = 'SELECT *                         ' .
                     'FROM #__modules                  ' .
                     'WHERE published = 1              ' .
                     '  AND access_min <= :rank        ' .
                     '  AND access_max >= :rank        ' .
                     'ORDER BY published DESC, ordering';

            // Data retrieval
            $stmt = $xDb->prepare($query);
            $stmt->bindParam(':rank', $xUser->rank, PDO::PARAM_INT);
            $stmt->execute();

         }

         // Create list
         $list = $stmt->fetchAll(PDO::FETCH_OBJ);
         $xCache->set('modules', $list);

      }

      return $list;
   }


   /**
    * Displays warning when JavaScript is disabled
    */
   public static function noScript() {
      global $xLang;

      $tpl = new XTemplate();
      $tpl->assign('xLang', $xLang);
      $tpl->display('templates/xtemplates/display-noscript.tpl');

   }


   /**
    * Displays the 404 page
    */
   public static function pageNotFound() {
      global $xLang;

      if (!headers_sent()) {

         header('HTTP/1.1 404 Not Found');
         header('Status: 404 Not Found');

      }

      Xirt::displayMessage(
         $xLang->headers['pageNotFound'],
         $xLang->bodies['pageNotFound']
      );

      trigger_error("[XCore] Page not found (404).", E_USER_NOTICE);

   }


   /**
    * Displays the 401 page
    */
   public static function notAuthorized() {
      global $xLang;

      if (!headers_sent()) {

         header('HTTP/1.1 401 Unauthorized');
         header('Status: 401 Unauthorized');

      }

      trigger_error("[XCore] Unauthorized access (401).", E_USER_NOTICE);

      Xirt::displayMessage(
         $xLang->headers['unauthorized'],
         $xLang->bodies['unauthorized']
      );

   }


   /**
    * Shows a custom message
    *
    * @param $title String containing the title of the message
    * @param $body String containing the message
    */
   public static function displayMessage($title, $body) {

      $tpl = new XTemplate();
      $tpl->assign('header', $title);
      $tpl->assign('message', $body);
      $tpl->display('templates/xtemplates/display-message.tpl');

   }


//   /**
//    * Sorting method to sort by child 'iso'
//    *
//    * @param $a The first item to compare
//    * @param $b The second item to compare
//    * @return int -1, 0, or 1 for 'less', 'equal to' or 'greater'
//    */
//   protected static function _sortByIso($a, $b) {
//
//      if (function_exists('gmp_cmp')) {
//         return gmp_cmp($a->preference, $b->preference);
//      }
//
//      if ($a->preference < $b->preference) {
//         return -1;
//      }
//
//      return intval($a->preference > $b->preference);
//   }

}
?>