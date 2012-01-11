<?php

/**
 * Class that handles all communication with the set database
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XDatabase extends PDO {

   /**
    * @var int Execution time for queries
    */
   var $timer = 0;


   /**
    * @var Array Holds all inserted queries
    */
   var $cache = array();


   /**
    * @var PDOStatement Current prepared query
    */
   var $pdo = null;


   /**
    * CONSTRUCTOR
    *
    * @param $dsn The DSN String to connect to the database (optional)
    * @param $user The username to connect to the database (optional)
    * @param $password The password to connect to the database (optional)
    * @throws XException
    */
   function __construct($dsn = false, $user = false, $password = false) {
      global $xConf;

      $dsn      = $dsn  ? $dsn  : $xConf->dbDSN;
      $user     = $user ? $user : $xConf->dbUser;
      $password = $password ? $password : $xConf->dbPass;

      parent::__construct($dsn, $user, $password);
      $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->setCharset('utf8');

   }


   /**
    * Sets the charset for the current connection
    *
    * @param $charset The charset to use
    * @throws XException
    */
   public function setCharset($charset = 'utf8') {

      $this->setQuery('SET CHARACTER SET ' . $charset);
      $this->query();

   }


   /**
    * Sets the current query to be executed
    *
    * @param $query The new query to set for execution
    * @throws XException
    */
   public function setQuery($query) {
      global $xConf;

      $query = str_replace('#_', $xConf->dbPrefix, $query);
      $this->pdo = $this->prepare($query);
      $this->cache[] = $query;

   }


   /**
    * Returns the current query
    *
    * @return String The current query
    * @throws XException
    */
   public function getQuery() {
      return $this->cache[count($this->cache) - 1];
   }


   /**
    * Executes current query (SELECT) and returns result
    *
    * @return PDOStatement Object containing the results
    * @throws XException
    */
   public function query() {

      $this->_startTimer();
      $this->pdo->execute();
      $this->_stopTimer();

      return $this->pdo;
   }


   /**
    * Executes current query (UPDATE, DELETE, INSERT) and returns affected rows
    *
    * @return int The amount of affected rows
    * @throws XException
    */
   public function execute() {

      $this->_startTimer();
      $this->pdo->execute();
      $this->_stopTimer();

      return $this->pdo->rowCount();
   }


   /**
    * Insert a new record containing the given data
    *
    * @param $table String with the table for insertion
    * @param $data Object or Array containing the data to add (keys / values)
    */
   public function insert($table, $data) {

      $data = is_object($data) ? (array) $data : $data;

      if (!is_array($data)) {
         trigger_error("Invalid input type for SQL insertion.", E_USER_ERROR);
      }

      $keys = implode(',', array_keys($data));
      $values = implode("','", $data);

      $query = "INSERT INTO %s (%s) VALUES ('%s')";
      $this->setQuery(sprintf($query, $table, $keys, $values));
      $this->query();

   }


   /**
    * Returns the first field of the result (first row, first field)
    *
    * @return mixed The value of the first field or false on failure
    * @throws XException
    */
   public function loadResult() {

      $this->query();

      if ($row = $this->pdo->fetch(PDO::FETCH_NUM)) {
         return $row[0];
      }

      return null;
   }


   /**
    * Returns the first row of the result as an object
    *
    * @return Object
    * @throws XException
    */
   public function loadRow() {
      return $this->query()->fetch(PDO::FETCH_OBJ);
   }


   /**
    * Returns result as an object
    *
    * @return Object containing all returned rows
    * @throws XException
    */
   public function loadObjectList($key = false) {

      $this->query();

      $list = array();
      while ($row = $this->pdo->fetch(PDO::FETCH_OBJ)) {
         $key ? ($list[$row->$key] = $row) : ($list[] = $row);
      }

      return $list;
   }


   /**
    * Returns result as an associative array
    *
    * @return Array containing all returned rows
    * @throws XException
    */
   public function loadAssocList($key = false) {

      $this->query();

      $list = array();
      while ($row = $this->pdo->fetch(PDO::FETCH_ASSOC)) {
         $key ? ($list[$row[$key]] = $row) : ($list[] = $row);
      }

      return $list;
   }


   /**
    * Returns the amount of changes/results from last query
    *
    * @return int The number of affected rows
    * @throws XException
    */
   public function rowCount() {
      return $this->pdo->rowCount();
   }


   /**
    * Starts internal start for recording execution time
    *
    * @access private
    */
   private function _startTimer() {
      $this->start = microtime();
   }


   /**
    * Ends internal start for recording execution time
    *
    * @access private
    */
   private function _stopTimer() {

      $this->timer = microtime() - $this->start;
      unset($this->start);

   }

}
?>