<?php
$stmt = $db->prepare('SELECT * FROM client WHERE client_id = :client_id');
$stmt->execute(array('client_id' => CLIENT_ID));
$info = $stmt->fetch();

$sql_gen = 'UPDATE client SET
				business_name = :business_name,
				phone_area_code = :phone_area_code,
				phone_number_1 = :phone_number_1,
				phone_number_2 = :phone_number_2,
				fax_area_code = :fax_area_code,
				fax_number_1 = :fax_number_1,
				fax_number_2 = :fax_number_2,
				address_1 = :address_1,
				address_2 = :address_2,
				city = :city,
				state = :state,
				zipcode = :zipcode,
				mail_attn = :mail_attn
				WHERE client_id = :client_id';

$sql_pass = 'UPDATE client SET user_password = :password WHERE client_id = :client_id';

$params_gen = array(
		"business_name" => $_POST["business_name"],
		"phone_area_code" => $_POST["phone_area_code"].trim(),
		"phone_number_1" => $_POST["phone_number_1"].trim(),
		"phone_number_2" => $_POST["phone_number_2"].trim(),
		"fax_area_code" => $_POST["fax_area_code"].trim(),
		"fax_number_1" => $_POST["fax_number_1"].trim(),
		"fax_number_2" => $_POST["fax_number_2"].trim(),
		"address_1" => $_POST["address_1"].trim(),
		"address_2" => $_POST["address_2"].trim(),
		"city" => $_POST["city"].trim(),
		"state" => strtoupper($_POST["state"]),
		"zipcode" => $_POST["zipcode"],
		"mail_attn" => $_POST["mail_attn"].trim(),
		"client_id" => CLIENT_ID
);

$params_pass = array(
		"password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
		"client_id" => CLIENT_ID
);
?>