<?php
session_start();

// loading configuration file
require_once('config.inc.php');
require_once(_CORE_DIR_ . '/Autoloader.php');
require_once(_CORE_DIR_ . '/core.php');
require __DIR__ . '/../../vendor/autoload.php';

// registering autoloader
spl_autoload_register(array('Autoloader', 'load'));

// Add the generated 'classes' directory to the include path
set_include_path(_APP_DIR_ . '/classes' . PATH_SEPARATOR . get_include_path());

$loadConfig = new Config();
$loadConfig->load('api');
$loadConfig->load('auth0');

use Auth0\SDK\Auth0;

$domain        = Config::getKey('auth0','domain');
$client_id     = Config::getKey('auth0','clientId');
$client_secret = Config::getKey('auth0','clientSecret');
$redirect_uri  = Config::getKey('auth0','redirectUri');
$audience      = Config::getKey('auth0','audience');

if($audience == ''){
  $audience = 'https://' . $domain . '/userinfo';
}

$auth0 = new Auth0([
  'domain' => $domain,
  'client_id' => $client_id,
  'client_secret' => $client_secret,
  'redirect_uri' => $redirect_uri,
  'audience' => $audience,
  'scope' => 'openid email profile user_metadata',
  'persist_id_token' => true,
  'persist_access_token' => true,
  'persist_refresh_token' => true,
]);


$userInfo = $auth0->getUser();

$loginData = $userInfo['https://jgm:eu:auth0:com/user_metadata'];
$_SESSION['loginData'] = $loginData;

use \Firebase\JWT\JWT;

//TODO add expire date correctly
$token = array(
    "iss" => Config::getKey('auth0', 'myDomain'),
    "aud" => $audience,
    //"iat" => 1356999524,
    //"nbf" => 1357000000,
);
if (isset($loginData['userRole'])) {
    $token['userRole'] = $loginData['userRole'];
}
if (isset($loginData['userId'])) {
    $token['userId'] = $loginData['userId'];
}
//Generate token in order to test api connection
$jwt = JWT::encode($token, Config::getKey('api','jwtSecret'));

$_SESSION['jwt'] = $jwt;
$api = new ApiV2();
$api->setDoRedirectOnFail(false);
$api->get('maker?per_page=1');
#print '<hr>';
#var_dump(!$api->responseHadError());
#print '<hr>';
#var_dump($api->getResponseBody());


$router = new Router();
if (!$api->responseHadError()) {
    $_SESSION['accountId'] = $token['userId'];
    $_SESSION['jwt'] = $jwt;
    $_SESSION['payload']['userId'] = $token['userId'];
    $_SESSION['payload']['userRole'] = $token['userRole'];
} else {
    unset($_SESSION['accountId']);
    unset($_SESSION['loginData']);
    $responseJson = json_decode($api->getResponseBody());
    if ('JSON_ERROR_NONE'  == json_last_error()) {
        $_SESSION['loginError'] = $responseJson->error;
    } else {
        $_SESSION['loginError'] = 'Error while try to login';
    }
    $_SESSION['auth0__user'] = false;
    $router->redirect('/account/loginerror');
}
$router->redirect('/');
