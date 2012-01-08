<?php

/**
 * Class for creating an ordered list of country names
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XCountryList {

   /**
	 * @var The location of the translated country files
    */
   const LOCATION = 'languages/countries/%s.ini';


   /**
	 * @var The list with data
    */
   var $_list = array();


   /**
    * Constructor
    */
   function __construct() {

      foreach (Xirt::getLanguages(true) as $language) {

         $file = sprintf(self::LOCATION, $language->iso);

         if ($this->_list = parse_ini_file($file)) {
            break;
         }

      }

   }


   /**
    * Returns an all countries as an Array
    *
    * @param $start 2-digit ISO of the country to display first (optional)
    * @return Array containing all countries (sorted)
    */
   public function toArray($start = null) {

      $list = array();
      foreach ($this->_list as $iso => $country) {

         // Fix 'escaped' ISO's
         if (strlen($iso) > 2) {
            $iso = substr($iso, -2);
         }

         $list[$iso] = $country;
      }

      asort($list);
      if (!is_null($start) && array_key_exists($start, $list)) {
         $list = array_merge(array($start => $list[$start]), $list);
      }

      return $list;
   }

}
?>