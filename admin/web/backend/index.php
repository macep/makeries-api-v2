<?php
//session_save_path("/tmp");
session_start();
#date_default_timezone_set('GMT+0');
#date_default_timezone_set('Greenwich');
#date_default_timezone_set('Europe/Lisbon');
#var_dump('adasdas');exit;

//error_reporting(E_ALL);
error_reporting(0);


// loading configuration file
require_once('config.inc.php');
require_once(_CORE_DIR_ . '/Autoloader.php');
require_once(_CORE_DIR_ . '/core.php');
require __DIR__ . '/../../vendor/autoload.php';

// registering autoloader
spl_autoload_register(array('Autoloader', 'load'));

if (!isset($_SESSION['auth0__user'])) {
	$router = new Router();
	$router->redirect('/login.php');
}
// Add the generated 'classes' directory to the include path
set_include_path(_APP_DIR_ . '/classes' . PATH_SEPARATOR . get_include_path());
		
// Include the main Propel script
#require_once _APP_DIR_ . '/vendor/propel/runtime/lib/Propel.php';
#Propel::init(_APP_DIR_ . '/conf/tersel-conf.php');
#$con = Propel::getConnection('tersel');

//WE DO NOT CARE ABOUT THE PARAMS< JUST WANT TO CHECK THE URL
$url = $_SERVER["REQUEST_URI"];
if ($pos = strpos($url, '?')) {
		$url = substr($url, 0, $pos);
}
$requestUri = explode('/', $url);
if ('' == $requestUri[1]) {
		$matches['target']['c'] = 'page';
		$matches['target']['a'] = 'index';
} else {
		$matches['target']['c'] = $requestUri[1];
		$matches['target']['a'] = $requestUri[2];
}
///// TEST IFURL IS Correct
$urlOk = true;
preg_match("/[\w]*/", $matches['target']['c'], $data2, PREG_OFFSET_CAPTURE);
if ($data2[0][0]!=$matches['target']['c']) {
		$matches['target']['c'] = 'page';
		$matches['target']['a'] = 'error';
		$urlOk = false;
} else {
		preg_match("/[\w]*/", $matches['target']['a'], $data2, PREG_OFFSET_CAPTURE);
		if ($data2[0][0]!=$matches['target']['a']) {
			$matches['target']['c'] = 'page';
			$matches['target']['a'] = 'error';
			$urlOk = false;
		}
}
if (!isset($_SESSION['accountId']) || (0 == strlen($_SESSION['accountId']) && $matches['target']['c']!='account' && $matches['target']['a']!='login')) {
			$matches['target']['c'] = 'account';
			$matches['target']['a'] = 'login';
			$urlOk = true;
}

///// test if we have the action for the current request
$checkModule = _APP_DIR_.'/classes/app/'._APP_DIR_TYPE_.'/modules/'.strtolower($matches['target']['c']);
if (!file_exists($checkModule)) {
		$matches['target']['c'] = 'page';
		$matches['target']['a'] = 'notDefined';
		$urlOk = false;
}

if ($urlOk) {
#		Site::setUnixTime($data[0]);
	
	// loading the translation class (manually since we want to be sure we have the __ function all the time)
	require_once(_CORE_DIR_ . '/Lang.php');
	
	if (isset($_SESSION['accountId'])) {
					//will just check if valid and have correct session Id
					Logged::isActive();
	}
	
	// base application url
	$baseUrl = ( isset($_SERVER['SCRIPT_NAME']) ) ? str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])) : '';
	if ($baseUrl == '/') {
					$baseUrl = '';
	}
	define('_BASE_URL_', $baseUrl);
		
}
#var_dump($matches);exit;
include_helper('array');
include_helper('link');
#include_helper('date');

$router = new Router();
if (isset($_SESSION['accountId']) && $_SESSION['accountId']) {
	if (!isset($_SESSION['filter'])) {
		$_SESSION['filter'] = json_encode([]);
	}
	if (isset($_SESSION['payload']) && $_SESSION['payload']['userRole'] == 'readOnlyAdmin') {
		if (!in_array($matches['target']['a'], ['index','view','logout'])) {
			$router->redirect('/');
		}
	}
}

$loadConfig = new Config();
$loadConfig->load('api');
$loadConfig->load('auth0');

$router->dispatch(array('target'=>array('c'=>$matches['target']['c'],'a'=>$matches['target']['a'])));
