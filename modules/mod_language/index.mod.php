<?php

/**
 * Displays available languages for the website
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class mod_language extends XModule {

   /**
    * @var Style options
    */
   private static $_styles = array(
      'list-text', 'list-images', 'list-combined', 'list-select'
   );


   /**
    * Shows the content
    */
   function showNormal() {
      global $xConf;

      $languages = $this->_getLanguages();

      $tpl = new XTemplate($this->_location());
      $tpl->assign('languages', $languages);
      $tpl->assign('xConf', $this->xConf);
      $tpl->assign('iso', $xConf->language);

      // Restructure for Smarty (optional)
      if ($this->xConf->show_type == 3) {

         $list = array();
         foreach ($languages as $language) {

            $list[$language->url] = $language->name;

            if ($language->iso == $xConf->language) {
               $tpl->assign('current', $language->url);
            }

         }

         $tpl->assign('languages', $list);

      }

      // Show template
      $style = self::$_styles[$this->xConf->show_type];
      $tpl->display(sprintf('templates/%s.tpl', $style));

   }


   /**
    * Returns a list of languages available for selection
    *
    * @access private
    * @return Array containing all available languages
    */
   private function _getLanguages() {
      global $xConf;

      $list = array();

      foreach (Xirt::getLanguages() as $language) {

         if (!$language->published) {
            continue;
         }

         if ($xConf->language == $language->iso && !$this->xConf->show_all) {
            continue;
         }

         $language->url = $this->_getLink($language->iso);
         $list[$language->name] = $language;

      }

      // Sort languages (optional)
      if ($this->xConf->alpha_sort) {
         ksort($list);
      }

      return $list;
   }


   /**
    * Returns the link for the given language
    *
    * @access private
    * @param $iso The language of the requested link
    * @return String with the requested link
    */
   private function _getLink($iso) {
      global $xConf, $xLinks;

      if ($xConf->alternativeLinks) {

         $params = $_GET;

         if (isset($params['lang'])) {
            unset($params['lang']);
         }

         if (isset($params['cid'])) {
            unset($params['cid']);
         }

         ksort($params);
         $query = http_build_query($params);

         // Find / Create SEF variant
         if ($link = $xLinks->returnLinkByQuery($query, $iso)) {
            return $link->alternative;
         }

      }

      $params = array('lang' => $iso);
      $params = array_merge($params, $_GET);
      ksort($params);

      return 'index.php?' . http_build_query($params);
   }

}
?>
