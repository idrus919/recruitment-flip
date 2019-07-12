<?php
class DBConnect
{
	private $config = [];
	private $host, $username, $password, $database;

	public $connection;

	public function __construct($db = null) {
		$this->config = parse_ini_file(__DIR__ . '/config.ini');
		$this->host = $this->config['db_host'];
		$this->username = $this->config['db_username'];
		$this->password = $this->config['db_password'];
		$this->database = $db ? $db : $this->config['db_name'];
	}

	// get database connection
	public function getConnection()
	{
		try {
			$this->connection = new PDO('mysql:host='. $this->host .';dbname='. $this->database, $this->username, $this->password);
			$this->connection->exec('set names utf8');
	
			return $this->connection;
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode('Internal server error!');
			die;
		}
	}
}