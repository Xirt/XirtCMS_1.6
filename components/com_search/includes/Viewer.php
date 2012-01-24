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

   }

   // Method for pagination

}
?>