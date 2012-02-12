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
    * CONSTRUCTOR
    *
    * @param $dsn The DSN String to connect to the database (optional)
    * @param $user The username to connect to the database (optional)
    * @param $password The password to connect to the database (optional)
    * @throws XException
    */
   function __construct($dsn = false, $user = false, $password = false) {
      global $xConf;

      // Connections values for this instance
      $dsn      = $dsn ? $dsn  : $xConf->dbDSN;
      $user     = $user ? $user : $xConf->dbUser;
      $password = $password ? $password : $xConf->dbPass;

      // Initialize connection
      parent::__construct($dsn, $user, $password);

      // Default connections values
      $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('XQuery'));
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

      $stmt = $this->prepare("SET CHARACTER SET :charset");
      $stmt->bindParam(":charset", $charset);
      $stmt->execute();

   }


   /**
    * Sets the current query to be executed
    *
    * @param $query A valid SQL statement
    * @param $query attribute values for the returned PDOStatement
    * @throws XException
    */
   public function prepare($query, $driver_options = array()) {
      global $xConf;

      $query = str_replace('#_', $xConf->dbPrefix, $query);

      return parent::prepare($query, $driver_options);
   }


   /**
    * Sets the current query to be executed
    *
    * @deprecated
    * @param $query The new query to set for execution
    * @throws XException
    */
   public function setQuery($query) {
      global $xConf;

      print_r("Deprecated use of XDatabase::setQuery()");
      print_r($query);

      $query = str_replace('#_', $xConf->dbPrefix, $query);
      $this->pdo = $this->prepare($query);
      $this->cache[] = $query;

   }


   /**
    * Returns the current query
    *
    * @deprecated
    * @return String The current query
    * @throws XException
    */
   public function getQuery() {
      print_r("Deprecated use of XDatabase::getQuery()");
      return $this->cache[count($this->cache) - 1];
   }


   /**
    * Executes current query (SELECT) and returns result
    *
    * @deprecated
    * @return PDOStatement Object containing the results
    * @throws XException
    */
   public function query() {

      print_r("Deprecated use of XDatabase::query()");

      $this->startTimer();
      $this->pdo->execute();
      $this->stopTimer();

      return $this->pdo;
   }


   /**
    * Executes current query (UPDATE, DELETE, INSERT) and returns affected rows
    *
    * @deprecated
    * @return int The amount of affected rows
    * @throws XException
    */
   public function execute() {

      print_r("Deprecated use of XDatabase::execute()");

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
    * @return int The inserted ID or 0
    */
   public function insert($table, $data) {

      if (!count($data) || !$data = (array)$data) {
         return 0;
      }

      // Gather updates
      $values = array();
      foreach (array_keys($data) as $i => $field) {
         $values[] = ':db_holder_' . $i;
      }

      $fields = implode(',', array_keys($data));
      $values = implode(',', $values);

      // Database query
      $query = 'INSERT INTO %s (%s) VALUES (%s)';
      $query = sprintf($query, $table, $fields, $values);

      // Query execution
      $stmt = $this->prepare($query);
      foreach (array_values($data) as $i => $data) {
         $stmt->bindValue(':db_holder_' . $i, $data);
      }

      return $stmt->execute() ? $this->lastInsertId() : 0;
   }


   /**
    * Updates a (specific) record with the given data
    *
    * @param $table String with the table for update
    * @param $data Object or Array containing the data to update (keys / values)
    * @param $conditions The WHERE-conditions to specify specific records
    * @return int The amount of affected rows or 0
    */
   public function update($table, $data, $conditions = '1') {

      if (!count($data) || !$data = (array)$data) {
         return 0;
      }

      // Gather updates
      $updates = array();
      foreach (array_keys($data) as $i => $field) {
         $updates[] = $field . '= :db_holder_' . $i;
      }

      $updates = implode(', ', $updates);

      // Database query
      $query = 'UPDATE %s SET %s WHERE %s';
      $query = sprintf($query, $table, $updates, $conditions);

      // Query execution
      $stmt = $this->prepare($query);
      foreach (array_values($data) as $i => $data) {
         $stmt->bindValue(':db_holder_' . $i, $data);
      }

      return $stmt->execute() ? $stmt->rowCount() : 0;
   }


   /**
    * Removes a (specific) record with the given data
    *
    * @param $table String with the table for deletion
    * @param $conditions The WHERE-conditions to specify specific records
    * @return int The amount of affected rows or 0
    */
   public function delete($table, $conditions = '1') {

      // Database query
      $query = 'DELETE FROM %s WHERE %s';
      $query = sprintf($query, $table, $conditions);

      // Query execution
      $stmt = $this->prepare($query);
      return $stmt->execute() ? $stmt->rowCount() : 0;
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
   public function startTimer() {
      $this->start = microtime();
   }


   /**
    * Ends internal start for recording execution time
    *
    * @access private
    */
   public function stopTimer() {

      if (isset($this->start)) {
         $this->timer = microtime() - $this->start;
         unset($this->start);
      }

   }

}
?>
