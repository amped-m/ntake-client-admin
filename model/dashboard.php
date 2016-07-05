<?php
try {
	$stmt = $db->prepare('SELECT * FROM client WHERE client_id = :client_id');
	$stmt->execute(array('client_id' => CLIENT_ID));
	$client_info = $stmt->fetch();
	
} catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}

?>
