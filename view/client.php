<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Phone Verification by Twilio</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#enter_number").submit(function(e) {
          e.preventDefault();
          initiateCall();
        });
      });
      $(document).ready(function(){
			$("#enter_number_sms").submit(function(e) {
				e.preventDefault();
				initiateSms();
			});
		});

      function initiateCall() {
        $.post("call.php", { phone_number : $("#phone_number").val() }, 
          function(data) { showCodeForm(data.verification_code); }, "json");
        checkStatus();
      }
	
      function showCodeForm(code) {
        $("#verification_code").text(code);
        $("#verify_code").fadeIn();
        $("#enter_number").fadeOut();
      }

      function checkStatus() {
        $.post("status.php", { phone_number : $("#phone_number").val() }, 
          function(data) { updateStatus(data.status); }, "json");
      }

      function updateStatus(current) {
        if (current === "unverified") {
          $("#status").append(".");
          setTimeout(checkStatus, 3000);
        }
        else {
          success(); 
        }
      }

      function initiateSms() {
			$.post("sms.php", { phone_number : $("#phone_number_sms").val() },
			function(data) { showVerifyForm(); }, "json");
        checkStatus_sms();
      }
		function showVerifyForm() {
			$("#phone_number2").val($("#phone_number_sms").val());
			$("#enter_number_sms").fadeOut("fast");
			$("#verify_code_sms").fadeIn();
		}
		function checkStatus_sms() {
        $.post("status_sms.php", { phone_number : $("#phone_number_sms").val() }, 
          function(data) { updateStatus_sms(data.status); }, "json");
      }

      function updateStatus_sms(current) {
        if (current === "unverified") {
          $("#status").append(".");
          setTimeout(checkStatus, 3000);
        }
        else {
          success(); 
        }
      }

      function success() {
        $("#status").text("Verified!");
      }
      
      
    </script>
    
    <style>
		.table-nm tr {line-height: 30px;}
		.table-nm td, th {padding: 0 10px;}
    </style>
  </head>
  <body>
	  <?php
// Get the PHP helper library from twilio.com/docs/php/install
require_once('lib/Services/Twilio.php'); // Loads the library

// Your Account Sid and Auth Token from twilio.com/user/account

$sid = "AC1fa65a81c2591b246215920ca9ffc9fd"; 
$token = "300c4269a673067451610fa823b7030a";
$client = new Services_Twilio($sid, $token);
// Get an object from its sid. If you do not have a sid,
// check out the list resource examples on this page
?>
<div class="container client"> 
<h2 class="first-head">All Recorded files</h2>
<?php
foreach ($client->account->recordings as $recording) {
	?>
	
   <p><?php echo "https://api.twilio.com".$recording->uri; ?></p>
    <?php
}
?>
<h2>Call History</h2>
<table class="table-nm">
	<tr>
		<th>Phone Number</th>
		<th>Call Status</th>
		<th>Call Start Time</th>
		<th>Call End Time</th>
		<th>Call Duration</th>
		<th>Call Type</th>
		<th>Call SID</th>
		<th>Name</th>
		<th>Call Record</th>
		</tr>
<?php
foreach ($client->account->calls as $call) 
{
	?>
	<tr>
		<td><?php echo $call->to; ?></td>
		<td><?php echo $call->status; ?></td>
		<td><?php echo $call->start_time; ?></td>
		<td><?php echo $call->end_time; ?></td>
		<td><?php echo $call->duration; ?></td>
		<td><?php echo $call->direction; ?></td>
		<td><?php echo $call->sid; ?></td>
		<td><?php echo $call->name; ?></td>
		<?php
		$call_sid = $call->sid;
		foreach ($client->account->recordings->getIterator(0, 50, array(
        "CallSid" => $call_sid
			)) as $recording) {
		   
			?>
			   <td><a href="<?php echo "https://api.twilio.com".$recording->uri; ?>" target="blank"><img src="assets/images/play.png" alt="play"></a></td>
				<?php
			}
			?>
			</tr>
			<?php
		} 
	  ?>
	  </table>
	  <div class="message-history">
	  <h2>Message History</h2>
	  <table class="table-nm">
	<tr>
		<th>Phone Number</th>
		<th>Message Status</th>
		<th>Message Content</th>
		<th>Message Time</th>
		<th>Media File</th>
		<th>Unique SID</th>
		</tr>
<?php
foreach ($client->account->messages as $message) 
{
	?>
	<tr>
		<td><?php echo $message->to; ?></td>
		<td><?php echo $message->status; ?></td>
		<td><?php echo $message->body; ?></td>
		<td><?php echo $message->start_time; ?></td>
		<td><?php echo $message->num_media; ?></td>
		<td><?php echo $message->sid; ?></td>
	</tr>
	<?php
} 
	  ?>
	  </table>
	  </div>
	  <div class="entry-div">
	<div class="enter-number-div">
    <form id="enter_number">
      <p>Enter your phone number:</p>
      <p><input type="text" name="phone_number" id="phone_number" /><input type="submit" name="submit" value="Verify" /></p>
    </form>
    </div>
    <div id="verify_code" style="display: none;">
      <p>Calling you now.</p>
      <p>When prompted, enter the verification code:</p>
      <h1 id="verification_code"></h1>
      <p><strong id="status">Waiting...</strong></p>
    </div>
	<div class="enter-number-div">
	<form id="enter_number_sms">
		<p>Enter your phone number:</p>
		<p><input type="text" name="phone_number_sms" id="phone_number_sms" /> <input type="submit" name="submit" value="Verify SMS" /></p>
	</form>
	</div>
	<form id="verify_code_sms" style="display: none;" action="status_sms.php" method="post">
		<p>Sending you a text message with your verification code.</p>
		<p>Once received, enter it here:</p>
		<h1 id="verification_code"><input type="text" name="verification_code" maxlength="6" size="7" /></h1>
		<input type="hidden" value="" id="phone_number2" name="phone_number" />
		<p><input type="submit" value="Verify" /></p>
	</form>
	</div>
	</div>
	<style>
	h2.first-head {
    text-align: center;
    text-transform: uppercase;
    }
    header .nav-bar li {
  color: #eee;
  cursor: pointer;
  display: inline-block;
  font-size: 16px;
  list-style: outside none none;
  margin: 0 10px;
  text-transform: capitalize;
  transition: all 0.3s ease 0s;
}
header .nav-bar {
  float: right;
  margin-top: 20px;
}
.enter-number-div {
    width: auto;
    display: inline-block;
    margin-right: 10px;
}
.entry-div {
    margin: 18px 0;
    text-align: center;
}
.client {
  box-shadow: 0 0 4px #222222;
  margin-bottom: 20px;
  margin-top: 20px;
}
.table-nm td, th {
  font-size: 12px;
  padding: 0 10px;
}
.container.client > p {
  text-align: center;
}
.client > h2 {
  font-size: 22px;
}
h2.first-head {
  font-size: 24px;
  text-align: center;
  text-transform: uppercase;
}
.table-nm td, th {
  font-size: 12px;
  line-height: 22px;
  padding: 0 10px;
}
.container.client h2 {
  background: #ddd none repeat scroll 0 0;
  padding: 5px 0;
  text-align: center;
}
.client th {
    font-size: 12px;
}
.table-nm tr td:last-child {word-break: break-all;}
	</style>
  </body>
</html>
