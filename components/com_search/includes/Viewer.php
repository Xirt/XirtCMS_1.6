<?php

/**
 * Library to show search results / form
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Viewer {

   /**
    * Shows the main template
    */
   public static function showForm() {
      global $xCom;

      // Search date
      $data = Manager::getSearchData();
      $results = Manager::getSearchResults($data);
      $data = XTools::encodeHTML($data);

      // Form lists (limit)
      $limits = range(10, 100, 10);
      $limits = array_combine($limits, $limits);

      // Show template
      $tpl = new Template();
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->assign('xConf', $xCom->xConf);
      $tpl->assign('result', $results);
      $tpl->assign('limits', $limits);
      $tpl->assign('data', $data);
      $tpl->display('main.tpl');

      if ($results) { // Tijdelijk, om error te voorkomen (onderstaande is testcode)
         $url = "index.php?q=lorem&method=0&limit=10&content=com_search&cid=43&page=%d";
         $test = new Pagination($url, $data->page, floor($results->count / $data->limit));
         $test->show();
      }

   }

   // Method for pagination

}

class Pagination {

   function __construct($uri, $current = 0, $count = 1) {

      $this->current = $current;
      $this->count = $count;
      $this->uri = $uri;

   }

   function previous($token = null) {

      if ($this->current) {

         return sprintf(
            '<a href="%s" title="%s">%s</a>',
         sprintf($this->uri, $this->current - 1),
            "Next",
         $token ? $token : $this->current - 1
         );

      }

   }

   function current() {

      return $this->current;

   }

   function next($token = null) {

      if ($this->current + 1 < $this->count) {

         return sprintf(
            '<a href="%s" title="%s">%s</a>',
         sprintf($this->uri, $this->current + 1),
            "Next",
         $token ? $token : $this->current + 1
         );

      }

   }

   function show() {

      $tpl = new XTemplate();
      $tpl->assign('pagination', $this);
      $tpl->display('templates/xtemplates/display-navigation.tpl');

   }

}

?>