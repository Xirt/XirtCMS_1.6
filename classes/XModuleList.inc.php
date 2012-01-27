<?php

/**
 * Class holding a (filtered) list of modules
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XModuleList {

   /**
    * @var The list of modules
    */
   var $_list = array();


   /**
    * Constructor
    */
   function __construct() {
      $this->_list = Xirt::getModules();
   }


   /**
    * Filters the current list on type
    *
    * @param $type The type to keep
    */
   public function filterByType($type) {

      foreach ($this->_list as $key => $module) {

         if($module->type != $type) {
            unset($this->_list[$key]);
         }

      }

   }


   /**
    * Filters the current list on position
    *
    * @param $position The position to keep
    */
   public function filterByPosition($position) {
      global $xConf, $xPage, $xUser;

      $defined = array();
      $undefined = array();

      foreach ($this->_list as $module) {

         if (intval($module->published) !== 1) {
            continue;
         }

         if (!$module->mobile && $xConf->mobile) {
            continue;
         }

         if ($module->position != $position) {
            continue;
         }

         if (strpos($module->pages, "undef") !== false) {

            $undefined[] = $module;
            continue;

         }

         if (strpos($module->pages, "all") !== false) {

            $defined[] = $module;
            continue;

         }

         if (strpos($module->pages, "|{$xPage->cId}|") !== false) {

            $defined[] = $module;
            continue;

         }

      }

      $this->_list = count($defined) ? $defined : $undefined;

   }


   /**
    * Filters the current list on language (one translation is kept per module)
    *
    * @param $iso The preferred language to keep (optional)
    */
   public function filterByLanguage($iso = null) {
      global $xConf;

      $iso = is_null($iso) ? $xConf->language : $iso;

      // Remove obsolete translations
      $languages = Xirt::getLanguages();
      $preference = PHP_INT_MAX;

      foreach ($this->_list as $module) {

         if ($module->language == $iso) {

            $preference = $languages[$module->language]->preference;

            // Remove all other candidates
            foreach ($this->_list as $key => $item) {

               if ($item->xid != $module->xid) {
                  continue;
               }

               if ($languages[$item->language]->preference != $preference) {
                  unset($list[$key]);
               }
            }

            return;

         } else {

            // Remove candidates worse than current
            foreach ($this->_list as $key => $item) {

               if ($item->xid != $module->xid) {
                  continue;
               }

               if ($languages[$item->language]->preference > $preference) {
                  unset($this->_list[$key]);
               }

            }

         }

      }

   }


   /**
    * Returns the list as an Array
    *
    * @return Array The current list of modules
    */
   public function toArray() {
      return $this->_list;
   }

}
?>