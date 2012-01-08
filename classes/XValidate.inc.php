<?php

/**
 * Utility Class for validating input information
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XValidate {

   /**
    * Returns true if input matches digits only
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isDigits($str, $min = 0, $max = false) {

      if (!XValidate::hasLength($str, $min, $max)) {
         return false;
      }

      return is_numeric($str);
   }


   /**
    * Returns true if input is between min and max
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isRange($str, $min, $max) {
      return ($str >= $min && $str <= $max);
   }


   /**
    * Returns true if input matches letters only
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isAlphabetical($str, $min = 0, $max = false) {

      if (!XValidate::hasLength($str, $min, $max)) {
         return false;
      }

      return preg_match('/^[a-z]*$/i', $str);
   }


   /**
    * Returns true if input matches letters and digits only
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isAlphanumeric($str, $min = 0, $max = false) {

      if (!XValidate::hasLength($str, $min, $max)) {
         return false;
      }

      return preg_match('/^[a-z0-9]*$/i', $str);
   }


   /**
    * Returns true if input matches simple chars (a-Z0-9._%-) only
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isSimpleChars($str, $min = 0, $max = false) {

      if (!XValidate::hasLength($str, $min, $max)) {
         return false;
      }

      return preg_match('/^[a-z0-9._-]*$/i', $str);
   }


   /**
    * Returns true if input matches a phone number
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isPhone($str, $min = 1, $max = false) {

      if (!XValidate::hasLength($str, $min, $max)) {
         return false;
      }

      return preg_match('/^[0-9\s\(\)\+\-]*$/', $str);
   }


   /**
    * Returns true if input matches an e-mail address
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isMail($str, $min = 1, $max = false) {
      $regex = '/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';

      if (!XValidate::hasLength($str, $min, $max)) {
         return false;
      }

      return preg_match($regex, $str);
   }


   /**
    * Returns true if input matches a valid link (or is empty)
    *
    * @param $str The input string
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isLink($str) {
      $regx = '/^(http|shttp|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z0-9](\S*)?$/';
      return (preg_match($regx, $str));
   }


   /**
    * Returns true if input matches a decent password
    *
    * @param $str The input string
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isPassword($str) {

      $regex = '/(?=^.{6,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%^&*()]*$/';

      return preg_match($regex, $str);
   }


   /**
    * Returns true if input has at least the defined lenght
    *
    * @param $str The input string
    * @param $min The minimum allowed length of the string (optional)
    * @param $max The maximum allowed length of the string (optional)
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function hasLength($str, $min = 1, $max = false) {

      if ($max !== false) {
         return (strlen(trim($str)) >= $min && strlen($str) <= $max);
      }

      return (strlen(trim($str)) >= $min);
   }


   /**
    * Returns true if input is a zipcode for the current language
    *
    * @deprecated
    * @param $str The input string
    * @return boolean Returns true if valid, false otherwhise
    */
   public static function isZipcode($str) {
      global $xConf;

      switch ($xConf->language) {

         case 'nl-NL':
            return (preg_match('/^[0-9]{4}[[:space:]]*[A-Za-z]{2}$/', $str));
            break;

         default:
            return XValidate::isDigits($str, 6, 10);
            break;

      }

   }

}
?>