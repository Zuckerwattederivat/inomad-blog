<?php
  /*
  * PDO Database Class
  * Connect to database
  * Create prepared statements
  * Bind values
  * Return rows and results
  */

  class Database {

    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {

      // Set DSN
      $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
      // PDO options
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );
      
      // Create PDO instance or catch and display error
      try {

        $this->dbh = new PDO($dsn, $this->db_user, $this->db_pass, $options);

      } catch(PDOException $e) {

        $this->error = $e->getMessage();
        echo $this->error;
      }

    }

    // Perpare statement with query
    public function query($sql) {
      $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type=null) {

      // PDO default mode
      if (is_null($type)) {
        switch (true) {
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
          break;
          default:
            $type = PDO::PARAM_STR;
        }
      }

      $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
      return $this->stmt->execute();
    }

    // Get result as array of objects
    public function resultSet() {
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single result as object
    public function single() {
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount() {
      return $this->stmt->rowCount();
    }
  }
?>