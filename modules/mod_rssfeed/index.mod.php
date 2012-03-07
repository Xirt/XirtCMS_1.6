<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('classes/RSSFeed.php');
include_once('classes/RSSItem.php');

/**
 * Module to show RSS-feed on the website
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2012
 * @package    XirtCMS
 */
class mod_rssfeed extends XModule {

   /**
    * Shows the content
    */
   function showNormal() {

      $feed = $this->_getFeed();

      if ($items = $feed->toArray($this->xConf->limit)) {

         $tpl = new XTemplate($this->_location());
         $tpl->assign('xConf', $this->xConf);
         $tpl->assign('xLang', $this->xLang);
         $tpl->assign('items', $items);
         $tpl->display('templates/template.tpl');

      }

   }

   /**
    * Returns the given RSS Feed
    *
    * @access private
    * @return RSSFeed The requested RSSFeed object
    */
   private function _getFeed() {

      $feed = new RSSFeed($this->xConf->feed);
      $feed->parse();

      return $feed;
   }

}
?>