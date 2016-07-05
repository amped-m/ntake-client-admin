<?php
$stmt = $db->prepare('SELECT * FROM website_content WHERE client_id = :client_id');
$stmt->execute(array('client_id' => CLIENT_ID));
$contents = $stmt->fetch();

$stmt_1 = $db->prepare('SELECT * FROM practice_area WHERE client_id = :client_id ORDER BY orders');
$stmt_1->execute(array('client_id' => CLIENT_ID));

$stmt_2 = $db->prepare('SELECT * FROM offer WHERE client_id = :client_id');
$stmt_2->execute(array('client_id' => CLIENT_ID));


if (isset($_POST['save_general'])) {
	try {
		$sql = "UPDATE website_content SET
					gallery_subtitle_1 = :title,
					gallery_subtitle_2 = :subtitle,
					our_vision = :vision,
					contact_message = :contact_msg,
					facebook = :facebook,
					twitter = :twitter,
					google_plus = :google_plus
					WHERE client_id = :client_id";
		$stmt_3 = $db->prepare($sql);
		
		$params = array(
				"title" => $_POST["title"],
				"subtitle" => $_POST["subtitle"],
				"vision" => $_POST["vision"],
				"contact_msg" => $_POST["contact_msg"],
				"facebook" => $_POST["facebook"],
				"twitter" => $_POST["twitter"],
				"google_plus" => $_POST["google_plus"],
				"client_id" => CLIENT_ID
		);
		
		if ($stmt_3->execute($params)) {
			echo "<h1>success!</h1>";
		}
		else {
			echo "<h1>failed</h1>";
		}
		$stmt = $db->prepare('SELECT * FROM website_content WHERE client_id = :client_id');
		$stmt->execute(array('client_id' => CLIENT_ID));
		$contents = $stmt->fetch();
	}
	catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

if (isset($_POST['save_area'])) {
	try {
		foreach ($_POST["area"] as $key) {
			$area_content_id[] = explode(',', $key)[1];
			$area_name[] = explode(',', $key)[2];
			$area_order[] = explode(',', $key)[0];
		}
		
		for ($i = 0; $i < count($_POST["area"]); $i++) {
			if ($area_order[$i] == "0") {
				$sql = "DELETE FROM practice_area
						WHERE client_id = :client_id AND content_id = :content_id";
				$stmt_4 = $db->prepare($sql);
				$stmt_4->execute(array("client_id" => CLIENT_ID, "content_id" => $area_content_id[$i]));
			}
			else {
				$sql = "INSERT INTO practice_area(content_id, client_id, area, orders)
						VALUES (:content_id, :client_id, :area, :orders)
						ON DUPLICATE KEY UPDATE orders = :orders";
				
				$stmt_4 = $db->prepare($sql);
				$params_area = array(
						"content_id" => $area_content_id[$i],
						"client_id" => CLIENT_ID,
						"area" => $area_name[$i],
						"orders" => $area_order[$i]
				);
				$stmt_4->execute($params_area);
			}
		}
		$stmt_1 = $db->prepare('SELECT * FROM practice_area WHERE client_id = :client_id ORDER BY orders');
		$stmt_1->execute(array('client_id' => CLIENT_ID));
		echo "<p>saved</p>";
	}
	catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}
?>

<div class="container">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#tab-gen">General Contents</a></li>
		<li><a data-toggle="tab" href="#tab-area">Practice Area</a></li>
		<li><a data-toggle="tab" href="#tab-services">Services</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="tab-gen" class="tab-pane fade in active">
			<h1>General Contents</h1>
			
			<form method="post">
				<div class="form-section">
					<p>Please <b>Save</b> for content changes.</p>
					<button class="btn btn-info" id="save-general" name="save_general">Save</button>
					<p id="save-general-msg"></p>
				</div>
				<hr />
				
				<div class="form-section">
					<label>Title</label>
					<input type="text" value="<?php echo $contents['gallery_subtitle_1']; ?>" name="title" />
				</div>
				
				<div class="form-section">
					<label>Subtitle</label>
					<input type="text" value="<?php echo $contents['gallery_subtitle_2']; ?>" name="subtitle" />
				</div>
				
				<div class="form-section">
					<label>Our Vision</label>
					<textarea name="vision"><?php echo $contents['our_vision']; ?></textarea>
				</div>
				
				<div class="form-section">
					<label>Contact Form Text</label>
					<textarea name="contact_msg"><?php echo $contents['contact_message']; ?></textarea>
				</div>
				
				<div class="form-section">
					<label>Facebook</label>
					<input type="text" name="facebook" value="<?php echo $contents['facebook']; ?>" placeholder="https://www.facebook.com/" />
				</div>
				
				<div class="form-section">
					<label>Twitter</label>
					<input type="text" name="twitter" value="<?php echo $contents['twitter']; ?>" placeholder="https://twitter.com/" />
				</div>
				
				<div class="form-section">
					<label>Google Plus</label>
					<input type="text" name="google_plus" value="<?php echo $contents['google_plus']; ?>" placeholder="https://plus.google.com/" />
				</div>
			</form>
		</div>
		
		<div id="tab-area" class="tab-pane fade">
			<h1>Practice Area</h1>
			
			<form method="post">
				<div class="form-section">
					<p>Please <b>Save</b> for content changes.</p>
					<button class="btn btn-info" id="save-area" name="save_area">Save</button>
					<p id="save-area-msg"></p>
				</div>
				<hr />
				
				<select name="area[]" size="20" id="area-select">
				<?php
					$count = 1;
					while ($area = $stmt_1->fetch(PDO::FETCH_ASSOC)) {
						?><option data="<?php echo $count; ?>" value="<?php echo $area['orders']; ?>, <?php echo $area['content_id']; 
							?>, <?php echo $area['area']; ?>"><?php echo $area['area']; $count++; ?></option>
					<?php }
				?>
				</select>
			</form>
			
			<button id="up">UP</button>
			<button id="down">DOWN</button>
			<input type="text" placeholder="Area" id="area-add-input" />
			<button class="btn btn-success" id="area-add">Add</button>
			<button class="btn btn-danger" id="area-remove">Remove</button>
						
			
		</div>
		
		<div id="tab-services" class="tab-pane fade">
			<h1>Services</h1>
			
			<form method="post" id="services-form">
				<div class="form-section">
					<p>Please <b>Save</b> for content changes.</p>
					<button class="btn btn-info" id="save-services" name="save_services">Save</button>
					<p id="save-services-msg"></p>
				</div>
				<hr />
				<?php 
					while ($services = $stmt_2->fetch(PDO::FETCH_ASSOC)) {
						?><div class="form-section">
							<label>Service</label>
							<input type="text" value="<?php echo $services['title']; ?>" name="services-title-1" /><br />
							<textarea name="services-content-1"><?php echo $services['content']; ?></textarea>
						</div>
					<?php }
				?>
			</form>
			
			<p>Check the box to delete</p>
			<button class="btn btn-danger service-delete">DELETE</button>
			
			<hr />
				<h2>Add Services</h2>
				<div class="form-section">
					<div id="add-services-tool">
						<label>Service</label>
						<input type="text" name="services-title-1" /><br />
						<textarea name="services-content-1"></textarea>
						
						<button id="add-service" class="btn btn-success">ADD</button>
						<p id="add-services-msg">
					</div>
				</div>
				<hr />
		</div>
	</div>
</div>
