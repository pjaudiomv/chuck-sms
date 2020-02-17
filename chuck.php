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

// Alternate random chuck norris quote api
// $chuck = json_decode(file_get_contents("https://api.icndb.com/jokes/random"), true);
// $chuck_joke = html_entity_decode($chuck['value']['joke']);
$chuck = json_decode(file_get_contents("https://api.chucknorris.io/jokes/random"), true);
$chuck_joke = $chuck['value'];

if (isset($_REQUEST["SmsSid"])) {
    if (trim(strtoupper($body)) == strtoupper($keyword)) {
        $message = html_entity_decode($chuck_joke);

    } else {
        $message = "You must send a message with just the word \"$keyword\" in it.";
    }

    if (isset($_REQUEST['From']) && isset($_REQUEST['To'])) {
        $GLOBALS['twilioClient']->messages->create($_REQUEST['From'], array("from" => $_REQUEST['To'], "body" => $message));
    }
}

if (!isset($_REQUEST["SmsSid"])) {
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
    <Response>
        <Pause length="2"/>
        <Say voice="Polly.Kimberly"><?php echo $chuck_joke;?></Say>
    </Response>
<?php }
