<?php

/**
 * Class to handle Yubikey OTP verification
 * Partly based on a script by Tom Corwine (yubico@corwine.org)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Yubikey {

   /**
    * @var The base URL of the authentication server
    */
   const URL_BASE = 'https://api.yubico.com/wsapi/verify?';


   /**
    * @var The timeout value for requests (in seconds)
    */
   const CH_TIMEOUT = 10;


   /**
    * @var The maximum time tolerance (difference) between the server and client
    */
   const YBK_TOLERANCE = 600;


   /**
    * @var The genereated API client ID
    *
    * @access private
    */
   private $_api;


   /**
    * @var The secret key belonging to the generated API client ID
    *
    * @access private
    */
   private $_secret;


   /**
    * CONSTRUCTOR
    *
    * @param $api The generated API client ID
    * @param $secret The corresponding secret key
    */
   function __construct($api, $secret) {

      $this->_secret = base64_decode($secret);
      $this->_api  = $api;

   }


   /**
    * Verifies the given One Time Password (OTP)
    *
    * @param $otp String with the password to verify
    * @return Returns true on validation, false otherwhise
    */
   public function verify($otp) {

      if (!XValidate::hasLength($otp, 44, 44)) {
         return false;
      }

      if (!$this->otpIsModhex($otp)) {
         return false;
      }

      $yData = array();
      $yData['id']        = $this->_api;
      $yData['otp']       = $otp;
      $yData['timestamp'] = 1;
      $yData['h']         = $this->_encode(http_build_query($yData));

      if (!$data = $this->_communicate(http_build_query($yData))) {

         trigger_error('Failure to communicate with Yubikey', E_USER_WARNING);
         return false;

      }

      $params = explode("\r\n", $data);
      foreach ($params as $key => $param) {

         if (!$params[$key]) {
            unset($params[$key]);
         }

         if (substr($param, 0, 2) == 't=') {

            $stamp = substr(trim($param), 2);
            if (!$this->_validateStamp(substr($stamp, 0, -4))) {
               return false;
            }

         }

         if (substr($param, 0, 7) == 'status=') {

            $status = substr(trim($param), 7);

            if ($status != 'OK') {
               return false;
            }

         }

         if (substr($param, 0, 2) == 'h=') {

         	$signature = substr(trim($param), 2);
            unset($params[$key]);

         }

      }

      if (!$this->_validateSignature($params, $signature)) {
      	return false;
      }

      return true;
   }


   /**
    * Checks the format of the given OTP
    *
    * @access private
    * @param $otp String containing the OTP to check
    * @return boolean Returns true on valid OTP's, false otherwhise
    */
   private function otpIsModhex($otp) {

      $modhexChars = array('c','b','d','e','f','g','h','i',
                           'j', 'k','l','n','r','t','u','v');

      foreach (str_split($otp) as $char) {

         if (!in_array($char, $modhexChars)) {
            return false;
         }

      }

      return true;
   }


   /**
    * Communicates the data to the server for verification
    *
    * @access private
    * @param $query String containing the query for the server
    * @return mixed Returns false on failure, the result otherwhise
    */
   private function _communicate($query) {

      $ch = curl_init(Yubikey::URL_BASE . $query);

      curl_setopt($ch, CURLOPT_TIMEOUT,        Yubikey::CH_TIMEOUT);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Yubikey::CH_TIMEOUT);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

      $response = curl_exec($ch);
      curl_close($ch);

      return $response;
   }


   /**
    * Checks whether the difference between client and server time is acceptable
    *
    * @access private
    * @param $time Int with the return timestamp
    * @return boolean Returns true on succes, false on failure
    */
   private function _validateStamp($time) {

      $now = time();
      $stamp = date_format(date_create($time), 'U');

      if ($stamp - Yubikey::YBK_TOLERANCE > $now) {
         return false;
      }

      if ($stamp + Yubikey::YBK_TOLERANCE < $now) {
         return false;
      }

      return true;
   }


   /**
    * Uses retrieved signature to check validity of data
    *
    * @access private
    * @param $params Array containing the received data
    * @param $signature String containing the signature used to sign the data
    * @return boolean Returns true when the check succeeds, false otherwhise
    */
   private function _validateSignature($params, $signature) {

      sort($params);
      $data = implode('&', $params);

      if ($this->_encode($data) == $signature) {
         return true;
      }

      return false;
   }


   /**
    * Encodes data with the current secret key
    *
    * @access private
    * @param $data String containing the data to encode
    * @return String The encoded data
    */
   private function _encode($data) {

      return base64_encode(hash_hmac('sha1', $data, $this->_secret, true));
   }

}
?>