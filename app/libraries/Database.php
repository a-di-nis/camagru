<?php


//PDO Database Class
//Connect to database
//Create prepared statements
//Bind values
//Return rows and results

class Database {
	private $host;
	private $user;
	private $pass;
	private $dbname;
	private $dsn;
	
	private $dbh;
	private $stmt;
	private $error;
	
	public function __construct() {
		require(APPROOT . '/config/database.php');
		
		$this->host = $DB_HOST;
		$this->user = $DB_USER;
		$this->pass = $DB_PASS;
		$this->dbname = $DB_NAME;
		$this->dsn = $DB_DSN;

		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		
		// Create PDO instance
		try{
			$this->dbh = new PDO($this->dsn, $this->user, $this->pass, $options);
		} catch(PDOException $e){
			$this->error = $e->getMessage();
			echo $this->error;
		}
	}
	
	public function query($sql) {
		
		$this->stmt = $this->dbh->prepare($sql);
	}
	
	//bind values
	
	public function bind($param, $value, $type = null) {
		
		if (is_null($type)) {
			switch(true) {
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
	
	//execute the prepared stmt
	
	public function execute() {
		return $this->stmt->execute();
	}
	
	//get results set as array of objects
	
	public function resultSet() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	//get single record
	
	public function single() {
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
		
	}
	
	//get row count
	
	public function rowCount() {
		return $this->stmt->rowCount();
	}
}

?>