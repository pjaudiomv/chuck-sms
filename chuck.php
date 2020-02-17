<?php
require_once __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

$twilio_account_sid = "";
$twilio_auth_token = "";

try {
    $twilioClient = new Client($twilio_account_sid, $twilio_auth_token);
} catch (\Twilio\Exceptions\ConfigurationException $e) {
    error_log("Missing Twilio Credentials");
}

$keyword = "chuck";
$body = $_REQUEST['Body'];
$contact = $_REQUEST['From'];

if (trim(strtoupper($body)) == strtoupper($keyword)) {
    // Alternate random chuck norris quote api
    // $chuck = json_decode(file_get_contents("https://api.icndb.com/jokes/random"), true);
    // $message = $chuck['value']['joke'];

    $chuck = json_decode(file_get_contents("https://api.chucknorris.io/jokes/random"), true);
    $message = $chuck['value'];

} else {
    $message = "You must send a message with just the word \"$keyword\" in it.";
}

if (isset($_REQUEST['From']) && isset($_REQUEST['To'])) {
    $GLOBALS['twilioClient']->messages->create($_REQUEST['From'], array("from" => $_REQUEST['To'], "body" => $message));
}
