<?php
  require("lib/Services/Twilio.php");
  require("database.php");
  
  // require POST request
  if ($_SERVER['REQUEST_METHOD'] != "POST") die;

  // generate "random" 6-digit verification code
  $code = rand(100000, 999999);

  // save verification code in DB with phone number
  // attempts to delete existing entries first
  $number = mysql_real_escape_string($_POST["phone_number"]);
  db(sprintf("DELETE FROM numbers WHERE phone_number='%s'", $number));
  db(sprintf("INSERT INTO numbers (phone_number, verification_code) VALUES('%s', %d)", $number, $code));

  mysql_close();

  // initiate phone call via Twilio REST API    
  // Set our AccountSid and AuthToken 
  $AccountSid = "ACe46cfc552dcd97c22f3c2a3ae448ebb6";
  $AuthToken = "b846d4a2a3dbdb309cc284788904769e";
  
  // Instantiate a new Twilio Rest Client 
  $client = new Services_Twilio($AccountSid, $AuthToken);

  try {
    // make call
    $call = $client->account->calls->create(
      '+14137254508',                // Verified Outgoing Caller ID or Twilio number
      $number,                       // The phone number you wish to dial
      'http://test.amped-m.com/ntake-admin/twiml.php' // The URL of twiml.php on your server
    );
  } catch (Exception $e) {
    echo 'Error starting phone call: ' . $e->getMessage();
  }

  // return verification code as JSON
  $json = array();	
  $json["verification_code"] = $code;

  header('Content-type: application/json');
  echo(json_encode($json));
?>
