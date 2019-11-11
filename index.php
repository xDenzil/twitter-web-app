<?php

require 'autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

define('CONSUMER_KEY', '4dvhIGlVuHOAmpcPcB3fEVAOb');
define('CONSUMER_SECRET', 'uUPC5f9ExMCRHIRVXNxkgXU9NB36RoRVeJIZfFQQUAmVWmZusJ');
define('OAUTH_CALLBACK', 'https://twitterfeedapi.herokuapp.com/callback.php');

if (!isset($_SESSION['access_token'])) {
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK)); // Temporary Token
    $_SESSION['oauth_token'] = $request_token['oauth_token']; //Saving tokens to session
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token'])); //Send to Twitter's Authorization page
    header('Location: a' . $url);
} else { 
    echo('hello');
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $connection->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true']);
    echo $user->status->text;
    echo($user);
    
}
