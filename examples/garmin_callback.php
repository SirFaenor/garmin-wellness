<?php
use League\OAuth1\Client\Credentials\TokenCredentials;


/**
 * bootstrap
 */
session_start();
require_once __DIR__.'/../../../../vendor/autoload.php';
$config = require_once __DIR__.'/config.php';


/**
 * Check params
 */
if (!isset($_GET['oauth_token']) || !isset($_GET['oauth_verifier']) || !isset($_SESSION['temporary_credentials'])) {
    throw new Exception("Need temporary oauth credentials, oauth_token and oauth_verifier to proceed.");
}


/**
 * This is the third step of the auth flow.
 * We must change the temporary credentials for a valid user token.
 */
$server = new \SirFaenor\OAuth1\Client\Server\Garmin([
    'identifier' => $config["consumer_key"],
    'secret' => $config["consumer_secret"],
    'callback_uri' => $config["callback_uri"]
]);

// Retrieve the temporary credentials we saved before
$temporaryCredentials = unserialize($_SESSION['temporary_credentials']);

// We will now retrieve token credentials from the server
$tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);
if (! $tokenCredentials instanceof TokenCredentials) {
    throw new Exception("Invalid response or token credentials");
}
//var_dump($tokenCredentials);
$_SESSION['token_credentials'] = serialize($tokenCredentials); //saving user access token in session for test
?>
Everything ok. <br>
These are your credentials.<br>
<pre>
<?php var_dump($tokenCredentials); ?>
</pre>

<a href="apitest">Click here to proceed with the tests</a>

