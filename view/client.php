<?php
// Get the PHP helper library from twilio.com/docs/php/install
require('lib/Services/Twilio.php'); // Loads the library

// Your Account Sid and Auth Token from twilio.com/user/account
$account_sid = "ACe46cfc552dcd97c22f3c2a3ae448ebb6"; // Your Twilio account sid
$auth_token = "b846d4a2a3dbdb309cc284788904769e"; // 
$client = new Services_Twilio($account_sid, $auth_token);

$numbers = $client->account->available_phone_numbers->getList('US', 'Local', array(
        "AreaCode" => "510"
    ));
foreach($numbers->available_phone_numbers as $number) {
	echo"<pre>";
echo $number->phone_number;
echo"</pre>";
}

?>
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
      }a

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
  </head>
  <body>
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
