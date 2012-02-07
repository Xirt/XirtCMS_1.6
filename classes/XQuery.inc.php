<?php

/**
 * Class that extends the PDOStatement class for additional functionality
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XQuery extends PDOStatement {

   /**
    * @var The status of the statement
    */
   private $_isExecuted = false;


   /**
    * Executes the current statement
    *
    * @param $input Array with values to bind (treated as String)
    * @return boolean True on success, false on failure
    * @see PDOStatement::execute()
    */
   public function execute($input = null) {
      global $xDb;

      if ($xDb) $xDb->startTimer();
      $result = parent::execute($input);
      if ($xDb) $xDb->stopTimer();

      $this->_isExecuted = true;

      return $result;
   }


   /**
    * Returns the status of the statement
    *
    * @return boolean True is executed, false otherwhise
    */
   public function isExecuted() {
      return $this->_isExecuted;
   }

}
?>