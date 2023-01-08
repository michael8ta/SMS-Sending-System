<?php

$service_plan_id = "7fc4fcdd271f4f2584ad7688d0dc9fd4";
$bearer_token = "d9806013dcd84fc7b5e5087e1b19cc9b";

//Any phone number assigned to your API
$send_from = "447520651048";
//May be several, separate with a comma ,
$recipient_phone_numbers = "201015370911"; 
$message = "Test message to {$recipient_phone_numbers} from {$send_from}";

// Check recipient_phone_numbers for multiple numbers and make it an array.
if(stristr($recipient_phone_numbers, ',')){
  $recipient_phone_numbers = explode(',', $recipient_phone_numbers);
}else{
  $recipient_phone_numbers = [$recipient_phone_numbers];
}

// Set necessary fields to be JSON encoded
$content = [
  'to' => array_values($recipient_phone_numbers),
  'from' => $send_from,
  'body' => $message
];

$data = json_encode($content);

$ch = curl_init("https://us.sms.api.sinch.com/xms/v1/{$service_plan_id}/batches");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $bearer_token
    ));
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
//curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $bearer_token);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);

if(curl_errno($ch)) {
    echo "failure";
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo "success";
    echo $result;
}
curl_close($ch);

?>