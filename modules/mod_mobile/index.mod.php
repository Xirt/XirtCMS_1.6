<?php

/**
 * Module to allow switching between mobile / normal mode
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_mobile extends XModule {

   /**
    * Handles any normal requests
    */
   function showNormal() {
      global $xConf;

      // Show
      $tpl = new XTemplate($this->_location());
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('xMainConf', $xConf);
      $tpl->assign('xLang', $this->xLang);
      $tpl->assign('url', $this->_getLink());
      $tpl->display('main.tpl');

   }


   /**
    * Returns the toggling link for the current page
    *
    * @private
    * @param iso The language of the requested link
    * @return String with the requested link
    */
   private function _getLink($iso) {
      global $xConf, $xLinks;

      $params = $_GET;

      // Search SEF variant of query
      if ($xConf->sefUrls && false) {

         unset($params['mobile']);
         $query = http_build_query($params);

         $xLinks = $xLinks ? $xLinks : new XLinkList();
         if ($link = $xLinks->returnLinkByLink($query, $iso)) {

            return $link->uri_sef;

         }

      }

      $params['mobile'] = intval(!$xConf->mobile);
      return 'index.php?' . http_build_query($params);
   }

}
?>