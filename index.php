<?php 
require 'include/config.php';
if(!$user->is_logged_in()){ header('Location: login.php'); } 

include 'view/header.php';

if (isset($_GET['page'])) {
	require 'controller/' . $_GET['page'] . '.php';

} else {
	require 'controller/dashboard.php';
}

include 'view/footer.php';
?>