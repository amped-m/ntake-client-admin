<?php
if(!$user->is_logged_in()){ header('Location: login.php'); }

$page = "client";

require 'model/' . $page . ".php";
require 'view/' . $page . ".php";

?>
