<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="" content="" />
    <meta name="" content="" />
    <meta name="" content="" />
    <title><?php if(isset($title)){ echo $title; }?></title>
    
    <!-- <link rel="shortcut icon" href="assets/images/icon.png" /> -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <!-- <link rel="stylesheet" href="assets/" /> -->
    <link rel="stylesheet" href="assets/css/style.css" />
    
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!--<script src="assets/"></script>-->
</head>
<body>
	<!-- <header data-spy="affix" data-offset-top="0">
	 -->
	 <header>
		<?php 
			$nav_list = array(
					"home" => "dashboard",
					"my account" => "account",
					"my website" => "content",
					"my client" => "client",
					"log out" => "logout.php"
			);
		?>
		
		<img class="logo-top" src="assets/images/logo.png" alt="logo" />
		<ul class="nav-bar">
		<?php 
			foreach ($nav_list as $key => $value) {
				if ($key === "log out") {
					?><a href="<?php echo $value; ?>"><li><?php echo $key; ?></li></a>
				<?php } else {
				?><a href="index.php?page=<?php echo $value; ?>"><li><?php echo $key; ?></li></a>
			<?php }} ?>
		</ul>
		
		<div class="clear"></div>
	</header>