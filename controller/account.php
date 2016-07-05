<?php
if(!$user->is_logged_in()){ header('Location: login.php'); }

$page = "account";

require 'model/' . $page . ".php";

if(isset($_POST["submit_general"])){
	try {
		$stmt = $db->prepare($sql_gen);
	
		if ($stmt->execute($params_gen)) {
			echo "<p class='account-msg'>Saved!</p>";
		}
		else {
			echo "<p class='account-msg'>failed</p>";
		}
	
		$stmt = $db->prepare('SELECT * FROM client WHERE client_id = :client_id');
		$stmt->execute(array('client_id' => CLIENT_ID));
		$info = $stmt->fetch();
	}
	catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

if(isset($_POST["submit_password"])){
	try {
		$stmt = $db->prepare($sql_pass);
		
		if ($stmt->execute($params_pass)) {
			echo "<p class='account-msg'>Password Updated</p>";
		}
		else {
			echo "<p class='account-msg'><b>FAILED</b> :: Please try it again.</p>";
		}
	}
	catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

require 'view/' . $page . ".php";
?>