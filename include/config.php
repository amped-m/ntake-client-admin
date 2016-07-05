<?php
ob_start();
session_start();

define('DBHOST','localhost');
define('DBUSER','amped-m');
define('DBPASS','hello-amped');
define('DBNAME','amped-testing');
define('DIR','http://test.amped-m.com/ntake-admin');
define('SITEEMAIL','info@ntake-legal.com');
define('CLIENT_ID',1);


try {
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    echo '<p>'.$e->getMessage().'</p>';
    exit;
}

include 'classes/user.php';
include 'classes/phpmailer/mail.php';

$user = new User($db);
?>