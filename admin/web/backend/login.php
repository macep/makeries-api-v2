<?php
require_once('config.inc.php');
require_once(_CORE_DIR_ . '/Autoloader.php');
//require_once(_CORE_DIR_ . '/core.php');
require __DIR__ . '/../../vendor/autoload.php';

spl_autoload_register(array('Autoloader', 'load'));

use Auth0\SDK\Auth0;

$loadConfig = new Config();
$loadConfig->load('api');
$loadConfig->load('auth0');

$domain        = Config::getKey('auth0','domain');
$client_id     = Config::getKey('auth0','clientId');
$client_secret = Config::getKey('auth0','clientSecret');
$redirect_uri  = Config::getKey('auth0','redirectUri');
$audience      = Config::getKey('auth0','audience');

if($audience == ''){
  $audience = 'https://' . $domain . '/userinfo';
}

$auth0 = new Auth0([
#  'domain' => 'jgm.eu.auth0.com',
#  'client_id' => 'g6stR0wbsIX62L7Jigtp8CSLnmg4yd9d',
#  'client_secret' => 'r3A8R41ihfgEIV72dpcFNJqqvF7_rA5e0RnM6_lwoWv8is4b-Y960WPjuPQmJKGi',
#  'redirect_uri' => 'http://admin.makeries.local/callback.php',
#  'audience' => 'https://jgm.eu.auth0.com/userinfo',
  'domain' => $domain,
  'client_id' => $client_id,
  'client_secret' => $client_secret,
  'redirect_uri' => $redirect_uri,
  'audience' => $audience,
  'scope' => 'openid email profile user_metadata app_metadata',
  'persist_id_token' => true,
  'persist_access_token' => true,
  'persist_refresh_token' => true,
]);

$auth0->login();