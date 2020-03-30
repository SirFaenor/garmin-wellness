<?php
/**
 * bootstrap
 */
session_start();
require_once __DIR__.'/../../../../vendor/autoload.php';
$config = require_once __DIR__.'/config.php';


/**
 * We can make an api request
 */
$server = new \SirFaenor\OAuth1\Client\Server\Garmin([
    'identifier' => $config["consumer_key"],
    'secret' => $config["consumer_secret"],
    'callback_uri' => $config["callback_uri"]
]);


$params = [
    "uploadStartTimeInSeconds" => "1452470400",
    "uploadEndTimeInSeconds" => "1452556800"
];

$activitySummary = $server->getActivitySummary(unserialize($_SESSION['token_credentials']), $params);
print_r(json_decode($activitySummary));
