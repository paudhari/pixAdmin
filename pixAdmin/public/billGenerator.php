<?php
$access_key = "ORQM4T120VJHWD24LDWU"; //put your own access_key - found in admin panel
$secret_key = "f8101ac039b9f955c1af558424f4cc29"; //put your own secret_key - found in admin panel
$return_url = "http://devadmin-v1.ezowebo.com/redirectURL.php"; //put your own return_url.php here.

$txn_id = time() . rand(10000,99999);

$value = $_GET["amount"]; //Make sure the datatype of the value is STRING.  //Charge amount is in INR by default

$data_string = "merchantAccessKey=" . $access_key . "&transactionId=" .$txn_id . "&amount=" . $value;

$signature = hash_hmac('sha1', $data_string, $secret_key);

$amount = array('value' => $value, 'currency' => 'INR');

$bill = array('merchantTxnId' => $txn_id, 
              'amount' => $amount, 
              'requestSignature' => $signature, 
              'merchantAccessKey' => $access_key, 
              'returnUrl' => $return_url);

/*You can update these details in your records*/

echo json_encode($bill);

?>
