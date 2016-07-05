<?php
if(!$user->is_logged_in()){ header('Location: login.php'); }

$page = "dashboard";

require 'model/' . $page . ".php";
require 'view/' . $page . ".php";
?>