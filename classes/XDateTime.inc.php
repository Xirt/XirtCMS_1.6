<?php

/**
 * Utility class with abstract time related functions to support XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class XDateTime {

   /**
    * Returns the microtime since UNIX Epoch (0:00:00 January 1, 1970 GMT)
    *
    * @return float Containing the time passed since UNIX Epoch
    */
   public static function getmicrotime() {
      list($usec, $sec) = explode(' ', microtime());
      return ((float)$usec + (float)$sec);
   }


   /**
    * Returns a full date (including day using language files)
    *
    * @param $stamp The timestamp to use (optional, defaults NOW)
    * @param $showTime Toggles time (optional, defaults false)
    * @return String The generated date string
    */
   public static function getFullDate($stamp = null, $showTime = false) {
      global $xLang;

      $stamp = $stamp ? $stamp : time();

      $date = array();
      $date[] = $xLang->days[date('N', $stamp) - 1];
      $date[] = date('d', $stamp);
      $date[] = $xLang->months[date('n', $stamp) - 1];
      $date[] = date('Y', $stamp);

      if ($showTime) {

         $date[] = date('H:i', $stamp);
         return implode(' ', $date);

      }

      return implode(' ', $date);
   }


   /**
    * Returns a relative date (relative to NOW)
    *
    * @param $stamp The timestamp to use
    * @return String The generated date string
    */
   public static function getRelativeDate($stamp) {
      global $xLang;

      $dif = time() - $stamp;

      if ($dif < 2) {
         return $xLang->relative['aSecAgo'];
      } elseif ($dif < 60) {
         return sprintf($xLang->relative['xSecsAgo'], $dif);
      } elseif ($dif < 120) {
         return $xLang->relative['aMinAgo'];
      } elseif ($dif < 2700) {
         return sprintf($xLang->relative['xMinsAgo'], round($dif / 60));
      } elseif ($dif < 5400) {
         return $xLang->relative['anHourAgo'];
      } elseif ($dif < 86400) {
         return sprintf($xLang->relative['xHoursAgo'], round($dif / 3600));
      } elseif ($dif < 172800) {
         return $xLang->relative['aDayAgo'];
      } elseif ($dif < 2592000) {
         return sprintf($xLang->relative['xDaysAgo'], round($dif / 86400));
      } elseif ($dif < 5184000) {
         return $xLang->relative['aMonthAgo'];
      } elseif ($dif < 31536000) {
         return sprintf($xLang->relative['xMonthsAgo'], round($dif / 2592000));
      } elseif ($dif < 63072000) {
         return $xLang->relative['aYearAgo'];
      }

      return sprintf($xLang->relative['xYearsAgo'], round($dif / 31536000));
   }

}
?>