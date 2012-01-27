<?php

require_once(_XDIR . 'config/config.inc.php');

/**
 * Page Generator: The core class that generates the whole page
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XEngine {

   /**
    * Loads and initializes the current page
    */
   function __construct() {

      XMakeCompatible::noCache();
      XMakeCompatible::prepareArguments();

      // Initialization
      $this->_init();

      // Content
      $this->_loadLanguage();
      $this->_loadUser();
      $this->_loadContent();
      $this->_loadTemplate();

   }


   /**
    * Initializes the core variables
    */
   private function _init() {
      global $xCache, $xConf, $xDb, $xLog;

      session_start();

      $xCache = new XCache();
      $xConf  = new XConfiguration();
      $xLog   = new XLog();
      $xDb    = new XDatabase();

      // Environment compatible
      XMakeCompatible::prepareSession();
      XmakeCompatible::prepareLink();

   }


   /**
    * Loads the language file
    *
    * @see XConfiguration
    */
   private function _loadLanguage() {
      global $xConf, $xLang;

      $languages = Xirt::getLanguages();
      if (!defined('_ADMIN') && !isset($languages[$xConf->language])) {
         $xConf->setLanguage(current($languages)->iso);
      }

      if (!defined('_ADMIN') && !$languages[$xConf->language]->published) {
         $xConf->setLanguage(current($languages)->iso);
      }

      $xLang = new XLanguage($xConf->language);
      $xLang->load();

   }


   /**
    * Loads the current user
    *
    * @see XUser
    */
   private function _loadUser() {
      global $xUser;

      if (XAuthentication::check()) {
         $id = XAuthentication::getUserId();
      }

      $xUser = new XUser(isset($id) ? $id : null);

   }


   /**
    * Loads the main content for the requested page
    *
    * @see XPage
    */
   private function _loadContent() {
      global $xConf, $xPage;

      $xPage = new XPage();

      switch (true) {

         case !$xConf->showTemplate:
            return $xPage->load(false);

         case XTools::isMobileRequest():
            return $xPage->load(false);

         case array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER):
            return $xPage->load(false);

      }

      $xPage->load();

   }


   /**
    * Loads the template for the requested page
    *
    * @see XTemplateLoader
    */
   private function _loadTemplate() {
      new XTemplateLoader();
   }

}
?>