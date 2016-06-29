<?php

/**
 * config.php
 *
 * Config
 *
 * @author     Josip Hrnjak
 * @copyright  2016 Josip Hrnjak
 * @version    v0.03

 */
// config.php

session_start();
/* Konfiguracija baze podataka */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'vjezbanje');
define("BASE_URL", "http://localhost/PHPLoginHash/"); // Eg. http://yourwebsite.com

// sadrži SALT koji se koristi za pojačavanje zaštite lozinke
define('AUTH_SALT', 'QzaG09LexKITXsxV6JO4UiMWc070QXvGSJ7SLTTP'); // ako promijenite salt - sve spremljene lozinke/hashevi postaju nevaljane

function getDB() 
{
	$dbhost=DB_SERVER;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	$dbname=DB_DATABASE;
	try {
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbConnection->exec("set names utf8");
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
    }
    catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
	}

}





?>