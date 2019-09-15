<?php
require_once('database.php');

//create database

try
{
	$conn = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASS);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	// Delete database if it exists
	$sql = "DROP DATABASE IF EXISTS `" . $DB_NAME. "`";
	$conn->exec($sql);
	
	$sql = "CREATE DATABASE `" . $DB_NAME . "`";
	// use exec() because no results are returned
	$conn->exec($sql);
	echo "Database created successfully";
	$conn->exec("use " . $DB_NAME . ";");
}
catch(PDOException $e)
{
	echo $e->getMessage() . PHP_EOL;
	exit(0);
}

echo "Database created" . PHP_EOL;

//create table users

try
{
	// sql to create table
	$sql = "CREATE TABLE `users` (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(50) NOT NULL,
		email VARCHAR(100) NOT NULL,
		password VARCHAR(255),
		token varchar(255) DEFAULT NULL,
		token_two varchar(255) DEFAULT NULL,
		verified BOOLEAN NOT NULL DEFAULT 0,
		created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		accept_notifications BOOLEAN NOT NULL DEFAULT 1)";
		// use exec() because no results are returned
		$conn->exec($sql);
		echo "Table users created successfully";
	}
catch(PDOException $e)
{
	echo $e->getMessage() . PHP_EOL;
	exit(0);
}

// CREATE TABLE GALLERY

try
{
	$sql = "CREATE TABLE `montages` (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		user_id INT(11) NOT NULL,
		filename VARCHAR(100) NOT NULL,
		created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP)";
		$conn->exec($sql);
		echo "Table montages created successfully";
	}
catch (PDOException $e)
{
	echo $e->getMessage() . PHP_EOL;
	exit(0);
}

// CREATE TABLE LIKE

try
{
	$sql = "CREATE TABLE `likes` (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		user_id INT(11) NOT NULL,
		montage_id INT(11) NOT NULL)";
		$conn->exec($sql);
		echo "Table like created successfully";
}
catch (PDOException $e)
{
	echo $e->getMessage() . PHP_EOL;
	exit(0);
}

// CREATE TABLE COMMENT

try
{
	$sql = "CREATE TABLE `comments` (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		user_id INT(11) NOT NULL,
		montage_id INT(11) NOT NULL,
		comment VARCHAR(255) NOT NULL,
		created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP)";
		$conn->exec($sql);
		echo "Table comment created successfully";
}
catch (PDOException $e)
{
	echo $e->getMessage() . PHP_EOL;
	exit(0);
}

$conn = null;

?>