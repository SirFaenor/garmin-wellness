<?php
use League\OAuth1\Client\Credentials\TemporaryCredentials;

/**
 * bootstrap
 */
session_start();
require_once __DIR__.'/../../../../vendor/autoload.php';
$config = require_once __DIR__.'/config.php';


/**
 * This is the first step of the authorization process.
 * Temporary credentials must be something like 
 *  League\OAuth1\Client\Credentials\TemporaryCredentials {
 *      #identifier: "cfb73f67-46e1-4bae-9a7f-4b0b6bdb6d32"
 *      #secret: "0MPEOeJMWTTeePsT606sj4I0zUFP7kenRVi"
 * }
 */

$server = new \SirFaenor\OAuth1\Client\Server\Garmin([
    'identifier' => $config["consumer_key"],
    'secret' => $config["consumer_secret"],
    'callback_uri' => $config["callback_uri"]
]);
$temporaryCredentials = $server->getTemporaryCredentials();
//var_dump($temporaryCredentials);
if (! $temporaryCredentials instanceof TemporaryCredentials) {
    throw new Exception("Invalid response or credentials");
}
$_SESSION['temporary_credentials'] = serialize($temporaryCredentials);


/**
 * This is the second step of the auth flow.
 * Redirect user to Garmin Connect oauthCOnfirm page.
 */
$authUrl = $server->getAuthorizationUrl($temporaryCredentials);
?>

<br>
<pre>
<?php var_dump($authUrl); ?>
</pre>
<a href="<?= $authUrl ?>">Click here to proceed with the authentication</a>
