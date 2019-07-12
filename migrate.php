<?php
include_once './config/dbconnect.php';

try {
	$dbconnect = new DBConnect('INFORMATION_SCHEMA');

	$connection = $dbconnect->getConnection();
	$sql = file_get_contents(__DIR__ . '/config/data/database.sql');
	$connection->exec($sql);
	echo 'Database and tables created successfully!';
} catch (PDOException $e) {
	echo 'Error: '. $e->getMessage();
	die;
}