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
<table class="table-nm">
	<tr>
		<th>Phone Number</th>
		<th>Call Status</th>
		<th>Call Start Time</th>
		<th>Call End Time</th>
		<th>Call Duration</th>
		<th>Call Type</th>
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
	</tr>
	<?php
} 
	  ?>
	  </table>
    <form id="enter_number">
      <p>Enter your phone number:</p>
      <p><input type="text" name="phone_number" id="phone_number" /></p>
      <p><input type="submit" name="submit" value="Verify" /></p>
    </form>

    <div id="verify_code" style="display: none;">
      <p>Calling you now.</p>
      <p>When prompted, enter the verification code:</p>
      <h1 id="verification_code"></h1>
      <p><strong id="status">Waiting...</strong></p>
    </div>
    
  </body>
</html>
