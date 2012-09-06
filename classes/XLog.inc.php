<?php

/**
 * Class to generate log file entries and notify administrators
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XLog {

   /**
    * @var The (default) file to write fatal errors too
    */
   private $_file = 'events.log';


   /**
    * Creates a log with the given or default log file
    *
    * @param $file The file to use as log file (optional)
    */
   function __construct($file = null) {
      global $xConf;

      $this->_file = $file ? $file : $xConf->logDir . $this->_file;

      set_error_handler(array($this, 'onError'));
      set_exception_handler(array($this, 'onException'));

   }


   /**
    * Clears the contents of this log by deleting it
    */
   public function clear() {
      global $xDb;

      // Empty database
      $stmt = $xDb->prepare("TRUNCATE TABLE #__log");
      $stmt->execuse();

      // Empty event file
      if (file_exists($this->_file) && !@unlink($this->_file)) {
         trigger_error("Could not clear event log", E_USER_WARNING);
      }

      // Reset event notification
      $notification = $this->_file . '.notified';
      if (file_exists($notification) && !@unlink($notification)) {
         trigger_error("Could not reset notification", E_USER_WARNING);
      }

   }


   /**
    * Logs thrown Exceptions (fatals)
    *
    * @param $e The exception to be logged
    */
   public function onException(Exception $e) {

      $this->_log($this->_getData(
         E_USER_ERROR,
         $e->getMessage(),
         $e->getFile(),
         $e->getLine()
      ));

   }


   /**
    * Logs thrown (user generated) errors
    *
    * @param $n The error number of the event
    * @param $str The message explaining the event
    * @param $src The file in which the event was triggered
    * @param $Line The line in which the event was triggered
    * @see XLog::_log
    */
   public function onError($n, $str, $src, $line) {
      $this->_log($this->_getData($n, $str, $src, $line));
   }


   /**
    * Returns an object with extended information on the event
    *
    * @access private
    * @param $no The error number of the event
    * @param $str The message explaining the event
    * @param $src The file in which the event was triggered
    * @param $line The line in which the event was triggered
    * @return Object Extended information on event
    */
   private function _getData($no, $str, $src, $line) {

      $uri = $_SERVER['REQUEST_URI'];
      if (array_key_exists('QUERY_STRING', $_SERVER)) {
         $uri = $uri . '?' . $_SERVER['QUERY_STRING'];
      }

      return (object)array(
         'error_no'       => $no,
         'error_msg'      => $str,
         'error_src'      => $src,
         'error_line'     => $line,
         'request_ip'     => $_SERVER['REMOTE_ADDR'],
         'request_agent'  => $_SERVER['HTTP_USER_AGENT'],
         'request_uri'    => $uri,
         'request_method' => $_SERVER['REQUEST_METHOD'],
         'time'           => date("Y-m-d H:i:s")
      );

   }


   /**
    * Logs an event to the event log
    *
    * @access private
    * @param $data Extended information on event
    */
   private function _log($data) {
      global $xConf;

      // Capture error-control (@)
      if (0 === error_reporting()) {
         return false;
      }

      switch ($data->error_no) {

         case E_USER_NOTICE:
         case E_USER_WARNING:
            $this->_toDatabase($data);
            break;

         case E_USER_ERROR:
            $this->_toFile($data);
            $this->_notify($data);
            $this->_display($data);
            exit;

         default:

            // Hides notices / warnings in live-mode
            if ($xConf->debugMode && $data->error_no < E_USER_ERROR) {
               $this->_display($data);
            }

            break;

      }

   }


   /**
    * Saves event data to the database
    *
    * @access private
    * @param $data Extended information on event
    */
   private function _toDatabase($data) {
      global $xDb;

      if (isset($xDb) && !is_null($xDb)) {
         $xDb->insert('#__log', $data);
      }

   }


   /**
    * Saves event data to the log file
    *
    * @access private
    * @param $data Extended information on event
    */
   private function _toFile($data) {

      if (!$handle = @fopen($this->_file, 'a')) {
         die("Log file could not be opened.");
      }

      @fwrite($handle, sprintf("[%s]", $data->time));
      @fwrite($handle, sprintf("[%s]", $data->error_no));
      @fwrite($handle, sprintf(" %s" . nl , $data->error_msg));
      @fclose($handle);

   }


   /**
    * Shows errors when in debugmode
    *
    * @access private
    * @param $data Extended information on event
    */
   private function _display($data) {
      global $xConf, $xLang;

      $tpl = new XTemplate();
      $tpl->assign('data', $data);
      $tpl->assign('xLang', isset($xLang) ? $xLang : null);
      $tpl->assign('xConf', isset($xConf) ? $xConf : null);
      $tpl->display('templates/xtemplates/display-error.tpl');

   }


   /**
    * Notify the administrator of an event
    *
    * @access private
    * @param $data Extended information on event
    */
   private function _notify($data) {
      global $xConf;

      $file = $this->_file . '.notified';
      if (!isset($xConf) || @file_exists($file)) {
         return;
      }

      // Mail content
      $body = new XTemplate();
      $body->assign('data', $data);
      $body = $body->fetch('templates/xtemplates/mail-error.tpl');

      // Mail subject
      $mail = new XMail($xConf->adminMail, "[XirtCMS] Log event", $body);
      $mail->send();

      touch($file);

   }

}
?>